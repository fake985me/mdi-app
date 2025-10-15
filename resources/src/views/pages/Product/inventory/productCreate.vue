<template>
  <form
    @submit.prevent="submitProduct"
    class="space-y-4 max-w-xl mx-auto p-6 bg-white rounded-lg shadow"
  >
    <h2 class="text-2xl font-bold">Upload Produk</h2>

    <input v-model="name" type="text" placeholder="Product Name" class="input" required />
    <textarea v-model="description" placeholder="Deskripsi" class="input" required></textarea>

    <select v-model="categoryId" class="input" required>
      <option value="" disabled>Pilih Kategori</option>
      <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
    </select>

    <select v-model="subcategoryId" class="input" required>
      <option value="" disabled>Pilih Subkategori</option>
      <option v-for="sub in subcategoriesFiltered" :key="sub.id" :value="sub.id">
        {{ sub.name }}
      </option>
    </select>

    <input type="file" @change="handleFile" class="input" />

    <div class="flex justify-between">
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
  </form>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { getFirestore, collection, getDocs, addDoc, serverTimestamp } from 'firebase/firestore'
import { getStorage, ref as storageRef, uploadBytes, getDownloadURL } from 'firebase/storage'
import { slugify } from '@/utils/slugify' // Buat helper kalau belum ada

const name = ref('')
const description = ref('')
const categoryId = ref('')
const subcategoryId = ref('')
const thumbnailFile = ref(null)

const db = getFirestore()
const storage = getStorage()

const categories = ref([])
const subcategories = ref([])

const subcategoriesFiltered = computed(() =>
  subcategories.value.filter((s) => s.category_id === categoryId.value),
)

const handleFile = (e) => {
  thumbnailFile.value = e.target.files[0]
}

const loadCategories = async () => {
  const snap = await getDocs(collection(db, 'categories'))
  categories.value = snap.docs.map((doc) => ({ id: doc.id, ...doc.data() }))
}

const loadSubcategories = async () => {
  const snap = await getDocs(collection(db, 'subcategories'))
  subcategories.value = snap.docs.map((doc) => ({ id: doc.id, ...doc.data() }))
}

onMounted(() => {
  loadCategories()
  loadSubcategories()
})

const submitProduct = async () => {
  try {
    const slug = slugify(name.value)

    let thumbnailUrl = ''
    if (thumbnailFile.value) {
      const storagePath = `thumbnails/${slug}-${Date.now()}`
      const fileRef = storageRef(storage, storagePath)
      await uploadBytes(fileRef, thumbnailFile.value)
      thumbnailUrl = await getDownloadURL(fileRef)
    }

    const productRef = await addDoc(collection(db, 'products'), {
      name: name.value,
      slug,
      description: description.value,
      category_id: categoryId.value,
      subcategory_id: subcategoryId.value,
      thumbnail_url: thumbnailUrl,
      is_active: true,
      created_at: serverTimestamp(),
      updated_at: serverTimestamp(),
    })

    // Tambahkan detail default
    await addDoc(collection(db, `products/${productRef.id}/details`), {
      title: 'Default Detail',
      features: ['Feature A', 'Feature B'],
      specifications: {
        RAM: '8GB',
        Storage: '256GB',
      },
    })

    // Tambahkan inventory
    await addDoc(collection(db, 'inventory_status'), {
      product_id: productRef.id,
      stock_status: 'in_stock',
      stock_qty: 10,
    })

    alert('✅ Produk berhasil disimpan!')
  } catch (err) {
    console.error('❌ Gagal simpan produk:', err)
    alert('Terjadi kesalahan saat menyimpan produk.')
  }
}
</script>

<style scoped>
.input {
  @apply w-full p-2 border rounded;
}
.btn {
  @apply px-4 py-2 rounded text-white bg-blue-600 hover:bg-blue-700;
}
</style>
