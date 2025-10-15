import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import {
  getFirestore,
  collection,
  doc,
  getDocs,
  getDoc,
  query,
  where,
  orderBy,
  limit,
  addDoc,
  updateDoc,
  deleteDoc,
} from 'firebase/firestore'

import { auth } from '@/lib/firebaseConfig' // asumsi kamu punya konfigurasi firebase.js
const db = getFirestore()

export const useInventoryStore = defineStore('inventory', () => {
  const products = ref([])
  const categories = ref([])
  const subcategories = ref([])
  const inventoryStatus = ref([])
  const loading = ref(false)
  const error = ref(null)

  const productsByCategory = computed(() => {
    const grouped = {}
    products.value.forEach((product) => {
      const categoryName = product.category?.name || 'Uncategorized'
      if (!grouped[categoryName]) {
        grouped[categoryName] = []
      }
      grouped[categoryName].push(product)
    })
    return grouped
  })

  const lowStockProducts = computed(() =>
    inventoryStatus.value.filter(
      (item) => item.stock_status === 'low_stock' || item.stock_status === 'out_of_stock',
    ),
  )

  async function fetchCategories() {
    loading.value = true
    error.value = null
    try {
      const q = query(collection(db, 'categories'), where('is_active', '==', true), orderBy('name'))
      const snapshot = await getDocs(q)
      categories.value = snapshot.docs.map((doc) => ({ id: doc.id, ...doc.data() }))
    } catch (err) {
      error.value = err.message
    } finally {
      loading.value = false
    }
  }

  async function fetchSubcategories(categoryId) {
    loading.value = true
    error.value = null
    try {
      let q = query(
        collection(db, 'subcategories'),
        where('is_active', '==', true),
        orderBy('name'),
      )
      if (categoryId) {
        q = query(q, where('category_id', '==', categoryId))
      }
      const snapshot = await getDocs(q)
      subcategories.value = snapshot.docs.map((doc) => ({ id: doc.id, ...doc.data() }))
    } catch (err) {
      error.value = err.message
    } finally {
      loading.value = false
    }
  }

  async function fetchProducts(params = {}) {
    loading.value = true
    error.value = null
    try {
      let q = query(collection(db, 'products'), where('is_active', '==', true), orderBy('name'))

      if (params.categoryId) {
        q = query(q, where('category_id', '==', params.categoryId))
      }

      if (params.subcategoryId) {
        q = query(q, where('subcategory_id', '==', params.subcategoryId))
      }

      if (params.limit) {
        q = query(q, limit(params.limit))
      }

      const snapshot = await getDocs(q)
      products.value = snapshot.docs.map((doc) => ({ id: doc.id, ...doc.data() }))
    } catch (err) {
      error.value = err.message
    } finally {
      loading.value = false
    }
  }

  async function fetchInventoryStatus() {
    loading.value = true
    error.value = null
    try {
      const q = query(collection(db, 'inventory_status'), orderBy('name'))
      const snapshot = await getDocs(q)
      inventoryStatus.value = snapshot.docs.map((doc) => ({ id: doc.id, ...doc.data() }))
    } catch (err) {
      error.value = err.message
    } finally {
      loading.value = false
    }
  }

  async function createProduct(productData) {
    loading.value = true
    error.value = null
    try {
      const docRef = await addDoc(collection(db, 'products'), productData)
      const newDoc = await getDoc(docRef)
      const newData = { id: newDoc.id, ...newDoc.data() }
      products.value.push(newData)
      return { success: true, data: newData }
    } catch (err) {
      error.value = err.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function updateProduct(id, updates) {
    loading.value = true
    error.value = null
    try {
      const productRef = doc(db, 'products', id)
      await updateDoc(productRef, updates)
      const updatedSnap = await getDoc(productRef)
      const updatedData = { id, ...updatedSnap.data() }

      const index = products.value.findIndex((p) => p.id === id)
      if (index !== -1) {
        products.value[index] = updatedData
      }

      return { success: true, data: updatedData }
    } catch (err) {
      error.value = err.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  async function deleteProduct(id) {
    loading.value = true
    error.value = null
    try {
      await deleteDoc(doc(db, 'products', id))
      products.value = products.value.filter((p) => p.id !== id)
      return { success: true }
    } catch (err) {
      error.value = err.message
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  return {
    products,
    categories,
    subcategories,
    inventoryStatus,
    loading,
    error,
    productsByCategory,
    lowStockProducts,
    fetchCategories,
    fetchSubcategories,
    fetchProducts,
    fetchInventoryStatus,
    createProduct,
    updateProduct,
    deleteProduct,
  }
})
