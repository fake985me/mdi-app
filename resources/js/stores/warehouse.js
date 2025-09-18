import { defineStore } from 'pinia'

export const useWarehouseStore = defineStore('warehouse', {
  state: () => ({
    products: [],
    categories: [],
    subcategories: [],
    sales: [],
    purchases: [],
    stockMovements: [],
    warranties: [],
    borrowings: [],
    loading: false,
    error: null
  }),

  actions: {
    // Products
    async fetchProducts() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('products')
          .select(`
            *,
            categories (name),
            subcategories (name)
          `)
          .order('created_at', { ascending: false })
        
        if (error) throw error
        this.products = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createProduct(product) {
      try {
        const { data, error } = await supabase
          .from('products')
          .insert([product])
          .select()
        
        if (error) throw error
        await this.fetchProducts()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async updateProduct(id, updates) {
      try {
        const { data, error } = await supabase
          .from('products')
          .update(updates)
          .eq('id', id)
          .select()
        
        if (error) throw error
        await this.fetchProducts()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteProduct(id) {
      try {
        const { data, error } = await supabase
          .from('products')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchProducts()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Categories
    async fetchCategories() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('categories')
          .select('*')
          .order('name')
        
        if (error) throw error
        this.categories = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createCategory(category) {
      try {
        const { data, error } = await supabase
          .from('categories')
          .insert([category])
          .select()
        
        if (error) throw error
        await this.fetchCategories()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async updateCategory(id, updates) {
      try {
        const { data, error } = await supabase
          .from('categories')
          .update(updates)
          .eq('id', id)
          .select()
        
        if (error) throw error
        await this.fetchCategories()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteCategory(id) {
      try {
        // First, update products to remove category reference
        await supabase
          .from('products')
          .update({ category_id: null })
          .eq('category_id', id)

        // Then delete the category
        const { data, error } = await supabase
          .from('categories')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchCategories()
        await this.fetchProducts()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Subcategories
    async fetchSubcategories() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('subcategories')
          .select(`
            *,
            categories (name)
          `)
          .order('name')
        
        if (error) throw error
        this.subcategories = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createSubcategory(subcategory) {
      try {
        const { data, error } = await supabase
          .from('subcategories')
          .insert([subcategory])
          .select()
        
        if (error) throw error
        await this.fetchSubcategories()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async updateSubcategory(id, updates) {
      try {
        const { data, error } = await supabase
          .from('subcategories')
          .update(updates)
          .eq('id', id)
          .select()
        
        if (error) throw error
        await this.fetchSubcategories()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteSubcategory(id) {
      try {
        // First, update products to remove subcategory reference
        await supabase
          .from('products')
          .update({ subcategory_id: null })
          .eq('subcategory_id', id)

        // Then delete the subcategory
        const { data, error } = await supabase
          .from('subcategories')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchSubcategories()
        await this.fetchProducts()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Sales
    async fetchSales() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('sales')
          .select(`
            *,
            profiles (full_name)
          `)
          .order('created_at', { ascending: false })
        
        if (error) throw error
        this.sales = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createSale(sale) {
      try {
        const { data, error } = await supabase
          .from('sales')
          .insert([sale])
          .select()
        
        if (error) throw error
        await this.fetchSales()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteSale(id) {
      try {
        const { data, error } = await supabase
          .from('sales')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchSales()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Purchases
    async fetchPurchases() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('purchases')
          .select(`
            *,
            products (name, sku)
          `)
          .order('created_at', { ascending: false })
        
        if (error) throw error
        this.purchases = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createPurchase(purchase) {
      try {
        const { data, error } = await supabase
          .from('purchases')
          .insert([purchase])
          .select()
        
        if (error) throw error
        await this.fetchPurchases()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deletePurchase(id) {
      try {
        const { data, error } = await supabase
          .from('purchases')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchPurchases()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Stock Movements
    async fetchStockMovements() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('stock_movements')
          .select(`
            *,
            products (name, sku)
          `)
          .order('created_at', { ascending: false })
        
        if (error) throw error
        this.stockMovements = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createStockMovement(movement) {
      try {
        const { data, error } = await supabase
          .from('stock_movements')
          .insert([movement])
          .select()
        
        if (error) throw error
        await this.fetchStockMovements()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Warranties
    async fetchWarranties() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('warranties')
          .select(`
            *,
            products (name, sku)
          `)
          .order('created_at', { ascending: false })
        
        if (error) throw error
        this.warranties = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createWarranty(warranty) {
      try {
        const { data, error } = await supabase
          .from('warranties')
          .insert([warranty])
          .select()
        
        if (error) throw error
        await this.fetchWarranties()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteWarranty(id) {
      try {
        const { data, error } = await supabase
          .from('warranties')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchWarranties()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Borrowings
    async fetchBorrowings() {
      this.loading = true
      try {
        const { data, error } = await supabase
          .from('borrowings')
          .select(`
            *,
            products (name, sku)
          `)
          .order('created_at', { ascending: false })
        
        if (error) throw error
        this.borrowings = data || []
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createBorrowing(borrowing) {
      try {
        const { data, error } = await supabase
          .from('borrowings')
          .insert([borrowing])
          .select()
        
        if (error) throw error
        await this.fetchBorrowings()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteBorrowing(id) {
      try {
        const { data, error } = await supabase
          .from('borrowings')
          .delete()
          .eq('id', id)
        
        if (error) throw error
        await this.fetchBorrowings()
        return { data, error: null }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    }
  }
})