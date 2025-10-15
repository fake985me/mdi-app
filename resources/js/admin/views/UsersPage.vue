<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Users Management</h1>
        <p class="text-gray-600">Manage system users and their roles</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add User</span>
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Users</p>
            <p class="text-2xl font-bold text-blue-600">{{ users.length }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <Users class="w-6 h-6 text-blue-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Admins</p>
            <p class="text-2xl font-bold text-purple-600">{{ adminCount }}</p>
          </div>
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
            <Shield class="w-6 h-6 text-purple-600" />
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Regular Users</p>
            <p class="text-2xl font-bold text-green-600">{{ regularUserCount }}</p>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <User class="w-6 h-6 text-green-600" />
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search users..."
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
          <select
            v-model="roleFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Roles</option>
            <option value="superadmin">Superadmin</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                User
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Email
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Created At
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in filteredUsers" :key="user.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                      <span class="text-white font-medium">
                        {{ user.full_name?.charAt(0) || 'U' }}
                      </span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ user.full_name }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ user.email }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span
                  class="inline-flex px-2 py-1 text-xs font-semibold rounded-full capitalize"
                  :class="getRoleClass(user.role)"
                >
                  {{ user.role }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(user.created_at) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="editUser(user)"
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  Edit
                </button>
                <button
                  v-if="user.id !== authStore.profile?.id"
                  @click="deleteUser(user.id)"
                  class="text-red-600 hover:text-red-900"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div v-if="showAddModal || editingUser" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          {{ editingUser ? 'Edit User' : 'Add New User' }}
        </h3>
        
        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input
              v-model="userForm.full_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div v-if="!editingUser">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
              v-model="userForm.email"
              type="email"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div v-if="!editingUser">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
              v-model="userForm.password"
              type="password"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select
              v-model="userForm.role"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="user">User</option>
              <option value="admin">Admin</option>
              <option value="superadmin">Superadmin</option>
            </select>
          </div>
          
          <div class="flex justify-end space-x-4">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 text-gray-600 hover:text-gray-800"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
            >
              {{ editingUser ? 'Update' : 'Add' }} User
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, reactive } from 'vue'
import { useAuthStore } from '../../stores/auth'
import { get, post, put, del } from '../../lib/api'
import { Plus, Users, Shield, User } from 'lucide-vue-next'

const authStore = useAuthStore()

const users = ref([])
const showAddModal = ref(false)
const editingUser = ref(null)
const searchQuery = ref('')
const roleFilter = ref('')

const userForm = reactive({
  full_name: '',
  email: '',
  password: '',
  role: 'user'
})

const adminCount = computed(() => {
  return users.value.filter(u => u.role === 'admin' || u.role === 'superadmin').length
})

const regularUserCount = computed(() => {
  return users.value.filter(u => u.role === 'user').length
})

const filteredUsers = computed(() => {
  let filtered = users.value

  if (searchQuery.value) {
    filtered = filtered.filter(u =>
      u.full_name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      u.email.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }

  if (roleFilter.value) {
    filtered = filtered.filter(u => u.role === roleFilter.value)
  }

  return filtered
})

const getRoleClass = (role) => {
  const classes = {
    superadmin: 'bg-red-100 text-red-800',
    admin: 'bg-purple-100 text-purple-800',
    user: 'bg-green-100 text-green-800'
  }
  return classes[role] || 'bg-gray-100 text-gray-800'
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString()
}

const fetchUsers = async () => {
  try {
    const response = await get('/users') // Assuming we'll add this endpoint
    if (response.ok) {
      const data = await response.json()
      users.value = data.data || data // Adjust based on API response structure
    } else {
      console.error('Failed to fetch users')
    }
  } catch (error) {
    console.error('Error fetching users:', error)
  }
}

const editUser = (user) => {
  editingUser.value = user
  Object.assign(userForm, {
    full_name: user.full_name,
    email: user.email,
    role: user.role
  })
}

const deleteUser = async (id) => {
  if (confirm('Are you sure you want to delete this user?')) {
    try {
      const response = await del(`/users/${id}`) // Assuming we'll add this endpoint
      if (response.ok) {
        await fetchUsers()
      } else {
        const errorData = await response.json()
        console.error('Failed to delete user:', errorData.message)
      }
    } catch (error) {
      console.error('Error deleting user:', error)
    }
  }
}

const handleSubmit = async () => {
  try {
    if (editingUser.value) {
      // Update existing user via API call
      const response = await put(`/users/${editingUser.value.id}`, {
        full_name: userForm.full_name,
        role: userForm.role
      })
      
      if (response.ok) {
        await fetchUsers()
      } else {
        const errorData = await response.json()
        console.error('Failed to update user:', errorData.message)
      }
    } else {
      // Create new user via API call
      const response = await post('/users', {
        name: userForm.full_name,
        email: userForm.email,
        password: userForm.password,
        password_confirmation: userForm.password,
        role: userForm.role
      })
      
      if (response.ok) {
        await fetchUsers()
      } else {
        const errorData = await response.json()
        console.error('Failed to create user:', errorData.message)
      }
    }
    closeModal()
  } catch (error) {
    console.error('Error submitting user:', error)
  }
}

const closeModal = () => {
  showAddModal.value = false
  editingUser.value = null
  Object.assign(userForm, {
    full_name: '',
    email: '',
    password: '',
    role: 'user'
  })
}

onMounted(() => {
  fetchUsers()
})
</script>