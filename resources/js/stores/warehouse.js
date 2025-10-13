import { defineStore } from 'pinia'
import { get, post, put, del } from '../lib/api'
import { saveAs } from 'file-saver'
import * as ExcelJS from 'exceljs'

export const useWarehouseStore = defineStore('warehouse', {
  state: () => ({
    products: [],
    categories: [],
    orders: [],
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
        const response = await get('/api/products')
        const data = await response.json()
        
        if (response.ok) {
          this.products = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch products')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createProduct(product) {
      try {
        const response = await post('/api/products', product)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchProducts()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create product')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async updateProduct(id, updates) {
      try {
        const response = await put(`/api/products/${id}`, updates)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchProducts()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to update product')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteProduct(id) {
      try {
        const response = await del(`/api/products/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchProducts()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete product')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Categories
    async fetchCategories() {
      this.loading = true
      try {
        const response = await get('/api/categories')
        const data = await response.json()
        
        if (response.ok) {
          this.categories = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch categories')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createCategory(category) {
      try {
        const response = await post('/api/categories', category)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchCategories()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create category')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async updateCategory(id, updates) {
      try {
        const response = await put(`/api/categories/${id}`, updates)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchCategories()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to update category')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteCategory(id) {
      try {
        const response = await del(`/api/categories/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchCategories()
          await this.fetchProducts()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete category')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Subcategories
    async fetchSubcategories() {
      this.loading = true
      try {
        const response = await get('/api/subcategories')
        const data = await response.json()
        
        if (response.ok) {
          this.subcategories = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch subcategories')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createSubcategory(subcategory) {
      try {
        const response = await post('/api/subcategories', subcategory)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchSubcategories()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create subcategory')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async updateSubcategory(id, updates) {
      try {
        const response = await put(`/api/subcategories/${id}`, updates)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchSubcategories()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to update subcategory')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteSubcategory(id) {
      try {
        const response = await del(`/api/subcategories/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchSubcategories()
          await this.fetchProducts()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete subcategory')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Sales
    async fetchSales() {
      this.loading = true
      try {
        const response = await get('/api/sales')
        const data = await response.json()
        
        if (response.ok) {
          this.sales = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch sales')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createSale(sale) {
      try {
        const response = await post('/api/sales', sale)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchSales()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create sale')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteSale(id) {
      try {
        const response = await del(`/api/sales/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchSales()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete sale')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Purchases
    async fetchPurchases() {
      this.loading = true
      try {
        const response = await get('/api/purchases')
        const data = await response.json()
        
        if (response.ok) {
          this.purchases = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch purchases')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createPurchase(purchase) {
      try {
        const response = await post('/api/purchases', purchase)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchPurchases()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create purchase')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deletePurchase(id) {
      try {
        const response = await del(`/api/purchases/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchPurchases()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete purchase')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Stock Movements
    async fetchStockMovements() {
      this.loading = true
      try {
        const response = await get('/api/stock-movements')
        const data = await response.json()
        
        if (response.ok) {
          this.stockMovements = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch stock movements')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createStockMovement(movement) {
      try {
        const response = await post('/api/stock-movements', movement)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchStockMovements()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create stock movement')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Warranties
    async fetchWarranties() {
      this.loading = true
      try {
        const response = await get('/api/warranties')
        const data = await response.json()
        
        if (response.ok) {
          this.warranties = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch warranties')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createWarranty(warranty) {
      try {
        const response = await post('/api/warranties', warranty)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchWarranties()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create warranty')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteWarranty(id) {
      try {
        const response = await del(`/api/warranties/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchWarranties()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete warranty')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Orders
    async fetchOrders() {
      this.loading = true
      try {
        const response = await get('/api/orders')
        const data = await response.json()
        
        if (response.ok) {
          this.orders = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch orders')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createOrder(order) {
      try {
        const response = await post('/api/orders', order)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchOrders()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create order')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteOrder(id) {
      try {
        const response = await del(`/api/orders/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchOrders()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete order')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Borrowings
    async fetchBorrowings() {
      this.loading = true
      try {
        const response = await get('/api/borrowings')
        const data = await response.json()
        
        if (response.ok) {
          this.borrowings = data.data || []
          return { data: data.data, error: null }
        } else {
          throw new Error(data.message || 'Failed to fetch borrowings')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      } finally {
        this.loading = false
      }
    },

    async createBorrowing(borrowing) {
      try {
        const response = await post('/api/borrowings', borrowing)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchBorrowings()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to create borrowing')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    async deleteBorrowing(id) {
      try {
        const response = await del(`/api/borrowings/${id}`)
        const data = await response.json()
        
        if (response.ok) {
          await this.fetchBorrowings()
          return { data, error: null }
        } else {
          throw new Error(data.message || 'Failed to delete borrowing')
        }
      } catch (error) {
        this.error = error.message
        return { data: null, error }
      }
    },

    // Import/Export
    async exportProducts() {
      try {
        this.loading = true
        await this.fetchProducts()
        
        // Prepare data for export
        const exportData = this.products.map(product => ({
          'ID': product.id,
          'Name': product.name,
          'Description': product.description,
          'Price': product.price,
          'Stock': product.stock,
          'SKU': product.sku,
          'Category ID': product.category_id,
          'Status': product.status ? 'Active' : 'Inactive',
          'Created At': product.created_at,
          'Updated At': product.updated_at
        }))
        
        // Create workbook
        const workbook = new ExcelJS.Workbook()
        const worksheet = workbook.addWorksheet('Products')
        
        // Add headers
        const headers = Object.keys(exportData[0] || {})
        worksheet.addRow(headers)
        
        // Add data
        exportData.forEach(item => {
          const row = headers.map(header => item[header])
          worksheet.addRow(row)
        })
        
        // Generate buffer
        const buffer = await workbook.xlsx.writeBuffer()
        
        // Save file
        const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
        saveAs(blob, `products_export_${new Date().toISOString().slice(0, 10)}.xlsx`)
        
        return { success: true, message: 'Products exported successfully' }
      } catch (error) {
        this.error = error.message
        return { success: false, message: error.message }
      } finally {
        this.loading = false
      }
    },

    async importProducts(file) {
      try {
        this.loading = true
        
        return new Promise((resolve, reject) => {
          const reader = new FileReader()
          
          reader.onload = async (e) => {
            try {
              const data = new Uint8Array(e.target.result)
              const workbook = new ExcelJS.Workbook()
              await workbook.xlsx.load(data)
              
              const worksheet = workbook.getWorksheet(1)
              const importedData = []
              
              // Get headers from the first row
              const headers = []
              worksheet.getRow(1).eachCell((cell, colNumber) => {
                headers[colNumber - 1] = cell.value
              })
              
              // Process data rows
              worksheet.eachRow((row, rowNumber) => {
                // Skip header row
                if (rowNumber === 1) return
                
                const rowData = {}
                row.eachCell((cell, colNumber) => {
                  rowData[headers[colNumber - 1]] = cell.value
                })
                importedData.push(rowData)
              })
              
              // Process and save each product
              const results = {
                success: 0,
                errors: []
              }
              
              for (let i = 0; i < importedData.length; i++) {
                const row = importedData[i]
                
                try {
                  // Prepare product data
                  const productData = {
                    name: row['Name'] || row['name'],
                    description: row['Description'] || row['description'] || '',
                    price: parseFloat(row['Price']) || parseFloat(row['price']) || 0,
                    stock: parseInt(row['Stock']) || parseInt(row['stock']) || 0,
                    sku: row['SKU'] || row['sku'] || '',
                    category_id: parseInt(row['Category ID']) || parseInt(row['category_id']) || 1,
                    status: (row['Status'] || row['status']) === 'Active' || row['Status'] === 'active' || true
                  }
                  
                  // Validate required fields
                  if (!productData.name || !productData.sku) {
                    results.errors.push(`Row ${i + 2}: Missing required fields (Name or SKU)`)
                    continue
                  }
                  
                  // Create product
                  await this.createProduct(productData)
                  results.success++
                  
                } catch (error) {
                  results.errors.push(`Row ${i + 2}: ${error.message}`)
                }
              }
              
              resolve(results)
            } catch (error) {
              reject(error)
            } finally {
              this.loading = false
            }
          }
          
          reader.onerror = () => {
            this.loading = false
            reject(new Error('Failed to read file'))
          }
          
          reader.readAsArrayBuffer(file)
        })
      } catch (error) {
        this.error = error.message
        throw error
      }
    }
  }
})