// src/i18n.js
import { createI18n } from 'vue-i18n'

const messages = {
  en: {
    title: 'Product List',
    add: 'Add Product',
    edit: 'Edit',
    delete: 'Delete',
    stats: 'Product Statistics',
  },
  id: {
    title: 'Daftar Produk',
    add: 'Tambah Produk',
    edit: 'Ubah',
    delete: 'Hapus',
    stats: 'Statistik Produk',
  },
}

export const i18n = createI18n({
  legacy: false,
  locale: 'id', // default
  messages,
})
