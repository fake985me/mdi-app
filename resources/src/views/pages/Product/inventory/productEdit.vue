<template>
  <div class="max-w-xl mx-auto p-6 bg-white shadow rounded-md">
    <h2 class="text-xl font-bold mb-4">Edit Produk</h2>

    <form @submit.prevent="updateProduct" class="space-y-4">
      <input v-model="name" class="input" placeholder="Nama Produk" />
      <textarea v-model="description" class="input" placeholder="Deskripsi"></textarea>

      <select v-model="categoryId" class="input">
        <option value="" disabled>Pilih Kategori</option>
        <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>

      <select v-model="subcategoryId" class="input">
        <option value="" disabled>Pilih Subkategori</option>
        <option v-for="sub in filteredSubcategories" :key="sub.id" :value="sub.id">
          {{ sub.name }}
        </option>
      </select>

      <input type="file" @change="handleFile" class="input" />

      <button class="btn">Simpan Perubahan</button>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'
import { getFirestore, doc, getDoc, updateDoc, collection, getDocs } from 'firebase/firestore'
import { getStorage, ref as sRef, uploadBytes, getDownloadURL } from 'firebase/storage'

const route = useRoute()
const db = getFirestore()
const storage = getStorage()

const productId = route.params.id

const name = ref('')
const description = ref('')
const categoryId = ref('')
const subcategoryId = ref('')
const thumbnailFile = ref(null)
const thumbnailUrl = ref('')

const categories = ref([])
const subcategories = ref([])

const filteredSubcategories = computed(() =>
  subcategories.value.filter((s) => s.category_id === categoryId.value),
)

onMounted(async () => {
  const docSnap = await getDoc(doc(db, 'products', productId))
  const data = docSnap.data()
  name.value = data.name
  description.value = data.description
  categoryId.value = data.category_id
  subcategoryId.value = data.subcategory_id
  thumbnailUrl.value = data.thumbnail_url

  const catSnap = await getDocs(collection(db, 'categories'))
  categories.value = catSnap.docs.map((d) => ({ id: d.id, ...d.data() }))

  const subSnap = await getDocs(collection(db, 'subcategories'))
  subcategories.value = subSnap.docs.map((d) => ({ id: d.id, ...d.data() }))
})

const handleFile = (e) => {
  thumbnailFile.value = e.target.files[0]
}

const updateProduct = async () => {
  let newThumbUrl = thumbnailUrl.value

  if (thumbnailFile.value) {
    const sref = sRef(storage, `thumbnails/${productId}-${Date.now()}`)
    await uploadBytes(sref, thumbnailFile.value)
    newThumbUrl = await getDownloadURL(sref)
  }

  await updateDoc(doc(db, 'products', productId), {
    name: name.value,
    description: description.value,
    category_id: categoryId.value,
    subcategory_id: subcategoryId.value,
    thumbnail_url: newThumbUrl,
    updated_at: new Date(),
  })

  alert('✅ Produk diperbarui!')
}
</script>

<style scoped>
.input {
  @apply w-full border p-2 rounded;
}
.btn {
  @apply px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700;
}
</style>
