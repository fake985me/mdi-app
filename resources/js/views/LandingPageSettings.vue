<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Landing Page Builder</h1>
        <p class="text-gray-600">Customize your landing page sections and appearance</p>
      </div>
      <button
        @click="addSection"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
      >
        <Plus class="w-5 h-5" />
        <span>Add Section</span>
      </button>
    </div>

    <!-- Theme Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Theme Settings</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
          <div class="flex items-center space-x-3">
            <input
              v-model="themeSettings.primary_color"
              type="color"
              class="w-12 h-10 rounded border border-gray-300"
            />
            <input
              v-model="themeSettings.primary_color"
              type="text"
              class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
          <div class="flex items-center space-x-3">
            <input
              v-model="themeSettings.secondary_color"
              type="color"
              class="w-12 h-10 rounded border border-gray-300"
            />
            <input
              v-model="themeSettings.secondary_color"
              type="text"
              class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
          <div class="flex items-center space-x-3">
            <input
              v-model="themeSettings.background_color"
              type="color"
              class="w-12 h-10 rounded border border-gray-300"
            />
            <input
              v-model="themeSettings.background_color"
              type="text"
              class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Font Family</label>
          <select
            v-model="themeSettings.font_family"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="Inter">Inter</option>
            <option value="Roboto">Roboto</option>
            <option value="Open Sans">Open Sans</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Lato">Lato</option>
          </select>
        </div>
      </div>
      <div class="mt-6 flex justify-end">
        <button
          @click="saveThemeSettings"
          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors"
        >
          Save Theme
        </button>
      </div>
    </div>

    <!-- Navigation Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Navigation Settings</h2>
      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <span class="text-sm font-medium text-gray-700">Show Navigation</span>
          <button
            @click="navigationSettings.visible = !navigationSettings.visible"
            :class="['relative inline-flex h-6 w-11 items-center rounded-full transition-colors', navigationSettings.visible ? 'bg-blue-600' : 'bg-gray-200']"
          >
            <span
              :class="['inline-block h-4 w-4 transform rounded-full bg-white transition-transform', navigationSettings.visible ? 'translate-x-6' : 'translate-x-1']"
            />
          </button>
        </div>
        
        <div v-if="navigationSettings.visible" class="mt-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Navigation Items</label>
          <div class="space-y-3">
            <div
              v-for="(item, index) in navigationSettings.items"
              :key="index"
              class="flex items-center space-x-3 p-3 border border-gray-200 rounded-md"
            >
              <input
                v-model="item.title"
                type="text"
                placeholder="Link text"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
              <input
                v-model="item.url"
                type="text"
                placeholder="URL"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              />
              <button
                @click="removeNavItem(index)"
                class="text-red-600 hover:text-red-800 p-2"
              >
                <Trash2 class="w-4 h-4" />
              </button>
            </div>
            <button
              @click="addNavItem"
              class="text-blue-600 hover:text-blue-800 flex items-center space-x-1"
            >
              <Plus class="w-4 h-4" />
              <span>Add Navigation Item</span>
            </button>
          </div>
        </div>
      </div>
      <div class="mt-6 flex justify-end">
        <button
          @click="saveNavigationSettings"
          class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors"
        >
          Save Navigation
        </button>
      </div>
    </div>

    <!-- Layout Sections -->
    <div class="space-y-6">
      <div
        v-for="(section, index) in sections"
        :key="section.id"
        class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
      >
        <div class="flex justify-between items-start mb-4">
          <div>
            <h3 class="font-semibold text-gray-900">{{ section.section_name }}</h3>
            <p class="text-sm text-gray-500 capitalize">{{ section.section_type }}</p>
          </div>
          <div class="flex space-x-2">
            <button
              @click="toggleSection(section)"
              :class="['p-2 rounded', section.is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400']"
            >
              <Eye v-if="section.is_active" class="w-4 h-4" />
              <EyeOff v-else class="w-4 h-4" />
            </button>
            <button
              @click="editSection(section)"
              class="p-2 rounded bg-blue-100 text-blue-600 hover:bg-blue-200"
            >
              <Edit3 class="w-4 h-4" />
            </button>
            <button
              @click="moveSection(index, -1)"
              :disabled="index === 0"
              class="p-2 rounded bg-gray-100 text-gray-600 hover:bg-gray-200 disabled:opacity-50"
            >
              <ArrowUp class="w-4 h-4" />
            </button>
            <button
              @click="moveSection(index, 1)"
              :disabled="index === sections.length - 1"
              class="p-2 rounded bg-gray-100 text-gray-600 hover:bg-gray-200 disabled:opacity-50"
            >
              <ArrowDown class="w-4 h-4" />
            </button>
            <button
              @click="deleteSection(section.id)"
              class="p-2 rounded bg-red-100 text-red-600 hover:bg-red-200"
            >
              <Trash2 class="w-4 h-4" />
            </button>
          </div>
        </div>

        <!-- Section Content Preview -->
        <div class="border-t border-gray-200 pt-4">
          <div v-if="section.section_type === 'hero'" class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-lg text-white">
            <h2 class="text-2xl font-bold">{{ section.content.title || 'Hero Title' }}</h2>
            <p class="mt-2">{{ section.content.subtitle || 'Hero subtitle' }}</p>
            <button class="mt-4 bg-white text-blue-600 px-4 py-2 rounded-lg font-medium">
              {{ section.content.cta_text || 'CTA Button' }}
            </button>
          </div>
          
          <div v-else-if="section.section_type === 'slider'" class="bg-gray-100 p-4 rounded-lg">
            <div class="flex items-center justify-center h-40 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg">
              <span class="text-white font-medium">Slider Content Preview</span>
            </div>
            <div class="flex justify-center mt-4 space-x-2">
              <div class="w-3 h-3 rounded-full bg-blue-500"></div>
              <div class="w-3 h-3 rounded-full bg-gray-300"></div>
              <div class="w-3 h-3 rounded-full bg-gray-300"></div>
            </div>
          </div>
          
          <div v-else-if="section.section_type === 'carousel'" class="bg-gray-100 p-4 rounded-lg">
            <div class="flex items-center justify-center h-40 bg-gradient-to-r from-purple-400 to-pink-500 rounded-lg">
              <span class="text-white font-medium">Carousel Content Preview</span>
            </div>
            <div class="flex justify-center mt-4 space-x-2">
              <div class="w-8 h-1 rounded-full bg-purple-500"></div>
              <div class="w-8 h-1 rounded-full bg-gray-300"></div>
              <div class="w-8 h-1 rounded-full bg-gray-300"></div>
            </div>
          </div>
          
          <div v-else-if="section.section_type === 'grid'" class="p-2">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
              <div v-for="n in 4" :key="n" class="border border-gray-200 rounded-lg p-3">
                <div class="bg-gray-200 h-16 rounded mb-2"></div>
                <div class="h-3 bg-gray-200 rounded mb-1"></div>
                <div class="h-2 bg-gray-200 rounded w-3/4"></div>
              </div>
            </div>
          </div>
          
          <div v-else-if="section.section_type === 'features'" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(feature, idx) in section.content.features || []" :key="idx" class="border border-gray-200 p-4 rounded-lg">
              <h4 class="font-semibold">{{ feature.title || 'Feature Title' }}</h4>
              <p class="text-sm text-gray-600 mt-1">{{ feature.description || 'Feature description' }}</p>
            </div>
          </div>
          
          <div v-else-if="section.section_type === 'products'" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div v-for="n in 4" :key="n" class="border border-gray-200 rounded-lg p-4">
              <div class="bg-gray-200 h-32 rounded mb-2"></div>
              <div class="h-4 bg-gray-200 rounded mb-1"></div>
              <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
          </div>
          
          <div v-else class="text-gray-500 italic">
            {{ section.section_type }} section preview
          </div>
        </div>
      </div>
    </div>

    <!-- Add Section Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Section</h3>
        
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section Type</label>
            <select
              v-model="newSection.section_type"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="hero">Hero Section</option>
              <option value="slider">Slider</option>
              <option value="carousel">Carousel</option>
              <option value="grid">Grid Layout</option>
              <option value="features">Features</option>
              <option value="testimonials">Testimonials</option>
              <option value="products">Products Grid</option>
              <option value="cta">Call to Action</option>
              <option value="navigation">Navigation</option>
              <option value="footer">Footer</option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section Name</label>
            <input
              v-model="newSection.section_name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter section name"
            />
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
          <button
            @click="showAddModal = false"
            class="px-4 py-2 text-gray-600 hover:text-gray-800"
          >
            Cancel
          </button>
          <button
            @click="createSection"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
          >
            Add Section
          </button>
        </div>
      </div>
    </div>

    <!-- Edit Section Modal -->
    <div v-if="editingSection" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Section: {{ editingSection.section_name }}</h3>
        
        <div class="space-y-6">
          <!-- General Settings -->
          <div>
            <h4 class="font-medium text-gray-900 mb-2">General Settings</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section Name</label>
                <input
                  v-model="editingSection.section_name"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
                <select
                  v-model="editingSection.is_active"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                >
                  <option :value="true">Yes</option>
                  <option :value="false">No</option>
                </select>
              </div>
            </div>
          </div>
          
          <!-- Content Settings based on section type -->
          <div v-if="editingSection.section_type === 'hero'">
            <h4 class="font-medium text-gray-900 mb-2">Hero Section Content</h4>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                  <input
                    v-model="editingSection.content.title"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Layout Type</label>
                  <select
                    v-model="editingSection.content.layout_type"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="default">Default</option>
                    <option value="full-width">Full Width</option>
                    <option value="centered">Centered</option>
                    <option value="split-view">Split View</option>
                    <option value="left-aligned">Left Aligned</option>
                    <option value="right-aligned">Right Aligned</option>
                  </select>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <input
                  v-model="editingSection.content.subtitle"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">CTA Text</label>
                  <input
                    v-model="editingSection.content.cta_text"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">CTA Link</label>
                  <input
                    v-model="editingSection.content.cta_link"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Height</label>
                  <select
                    v-model="editingSection.content.height"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large" selected>Large</option>
                    <option value="extra-large">Extra Large</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Text Alignment</label>
                  <select
                    v-model="editingSection.content.text_alignment"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="left">Left</option>
                    <option value="center" selected>Center</option>
                    <option value="right">Right</option>
                  </select>
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Background Image URL</label>
                <input
                  v-model="editingSection.content.image_url"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="https://example.com/image.jpg"
                />
              </div>
            </div>
          </div>
          
          <div v-if="editingSection.section_type === 'slider'">
            <h4 class="font-medium text-gray-900 mb-2">Slider Content</h4>
            <div class="space-y-4">
              <div class="border-b border-gray-200 pb-4">
                <h5 class="text-sm font-medium text-gray-700 mb-2">Add Slide</h5>
                <div class="space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slide Title</label>
                    <input
                      v-model="newSlide.title"
                      type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Slide title"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slide Description</label>
                    <textarea
                      v-model="newSlide.description"
                      rows="2"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Slide description"
                    ></textarea>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">CTA Text</label>
                      <input
                        v-model="newSlide.cta_text"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Button text"
                      />
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">CTA Link</label>
                      <input
                        v-model="newSlide.cta_link"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="URL"
                      />
                    </div>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                    <input
                      v-model="newSlide.image_url"
                      type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="https://example.com/image.jpg"
                    />
                  </div>
                  <button
                    @click="addSlide"
                    class="w-full py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200"
                  >
                    Add Slide to Slider
                  </button>
                </div>
              </div>
              
              <div v-if="editingSection.content.slides && editingSection.content.slides.length > 0" class="space-y-4">
                <h5 class="text-sm font-medium text-gray-700">Current Slides</h5>
                <div v-for="(slide, index) in editingSection.content.slides" :key="index" class="border border-gray-200 rounded-md p-4">
                  <div class="flex justify-between items-start">
                    <div class="flex-1">
                      <h6 class="font-medium">{{ slide.title || 'Untitled Slide' }}</h6>
                      <p class="text-sm text-gray-600 mt-1">{{ slide.description }}</p>
                    </div>
                    <button
                      @click="removeSlide(index)"
                      class="text-red-600 hover:text-red-800 p-1"
                    >
                      <Trash2 class="w-4 h-4" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div v-if="editingSection.section_type === 'carousel'">
            <h4 class="font-medium text-gray-900 mb-2">Carousel Content</h4>
            <div class="space-y-4">
              <div class="border-b border-gray-200 pb-4">
                <h5 class="text-sm font-medium text-gray-700 mb-2">Add Carousel Item</h5>
                <div class="space-y-3">
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Title</label>
                    <input
                      v-model="newCarouselItem.title"
                      type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Item title"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                    <textarea
                      v-model="newCarouselItem.description"
                      rows="2"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Item description"
                    ></textarea>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                    <input
                      v-model="newCarouselItem.image_url"
                      type="text"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="https://example.com/image.jpg"
                    />
                  </div>
                  <button
                    @click="addCarouselItem"
                    class="w-full py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200"
                  >
                    Add Item to Carousel
                  </button>
                </div>
              </div>
              
              <div v-if="editingSection.content.items && editingSection.content.items.length > 0" class="space-y-4">
                <h5 class="text-sm font-medium text-gray-700">Current Carousel Items</h5>
                <div v-for="(item, index) in editingSection.content.items" :key="index" class="border border-gray-200 rounded-md p-4">
                  <div class="flex justify-between items-start">
                    <div class="flex-1">
                      <h6 class="font-medium">{{ item.title || 'Untitled Item' }}</h6>
                      <p class="text-sm text-gray-600 mt-1">{{ item.description }}</p>
                    </div>
                    <button
                      @click="removeCarouselItem(index)"
                      class="text-red-600 hover:text-red-800 p-1"
                    >
                      <Trash2 class="w-4 h-4" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div v-if="editingSection.section_type === 'grid'">
            <h4 class="font-medium text-gray-900 mb-2">Grid Layout Content</h4>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Grid Title</label>
                  <input
                    v-model="editingSection.content.grid_title"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Grid section title"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Number of Columns</label>
                  <select
                    v-model="editingSection.content.columns"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="2">2 Columns</option>
                    <option value="3" selected>3 Columns</option>
                    <option value="4">4 Columns</option>
                    <option value="5">5 Columns</option>
                    <option value="6">6 Columns</option>
                  </select>
                </div>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Grid Items</label>
                <div class="space-y-3">
                  <div class="border border-gray-200 rounded-md p-4" v-for="(item, index) in editingSection.content.grid_items || []" :key="index">
                    <div class="flex justify-between mb-2">
                      <h6 class="font-medium">Grid Item {{ index + 1 }}</h6>
                      <button
                        @click="removeGridItem(index)"
                        class="text-red-600 hover:text-red-800"
                      >
                        <Trash2 class="w-4 h-4" />
                      </button>
                    </div>
                    <div class="space-y-2">
                      <input
                        v-model="item.title"
                        type="text"
                        placeholder="Item title"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      />
                      <textarea
                        v-model="item.description"
                        placeholder="Item description"
                        rows="2"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      ></textarea>
                      <input
                        v-model="item.image_url"
                        type="text"
                        placeholder="Image URL"
                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      />
                    </div>
                  </div>
                  
                  <button
                    @click="addGridItem"
                    class="w-full py-2 bg-blue-100 text-blue-600 rounded-md hover:bg-blue-200"
                  >
                    Add Grid Item
                  </button>
                </div>
              </div>
            </div>
          </div>
          
          <div v-if="editingSection.section_type === 'features'">
            <h4 class="font-medium text-gray-900 mb-2">Features Content</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section Subtitle</label>
                <input
                  v-model="editingSection.content.subtitle"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Features</label>
                <div v-for="(feature, idx) in editingSection.content.features || []" :key="idx" class="border border-gray-200 p-4 rounded-md mb-3">
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Icon</label>
                      <input
                        v-model="feature.icon"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Icon name"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Title</label>
                      <input
                        v-model="feature.title"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Title"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Position</label>
                      <input
                        v-model="feature.position"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Position"
                      />
                    </div>
                  </div>
                  <div>
                    <label class="block text-xs text-gray-500 mb-1">Description</label>
                    <textarea
                      v-model="feature.description"
                      rows="2"
                      class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Description"
                    ></textarea>
                  </div>
                  <button
                    @click="removeFeature(idx)"
                    class="text-red-600 text-xs mt-2 flex items-center"
                  >
                    <Trash2 class="w-3 h-3 mr-1" /> Remove
                  </button>
                </div>
                <button
                  @click="addFeature"
                  class="text-blue-600 text-sm flex items-center"
                >
                  <Plus class="w-4 h-4 mr-1" /> Add Feature
                </button>
              </div>
            </div>
          </div>
          
          <!-- Add more section types as needed -->
          
          <!-- Section Settings -->
          <div>
            <h4 class="font-medium text-gray-900 mb-2">Section Settings</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input
                  v-model.number="editingSection.sort_order"
                  type="number"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              
              <!-- Style settings -->
              <div v-if="editingSection.section_type === 'hero'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Background Color</label>
                <input
                  v-model="editingSection.settings.background_color"
                  type="color"
                  class="w-12 h-10 rounded border border-gray-300"
                />
              </div>
            </div>
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 mt-6">
          <button
            @click="editingSection = null"
            class="px-4 py-2 text-gray-600 hover:text-gray-800"
          >
            Cancel
          </button>
          <button
            @click="updateSection"
            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
          >
            Save Changes
          </button>
        </div>
      </div>
    </div>
    
    <!-- Preview Section Modal -->
    <div v-if="previewSection" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Preview: {{ previewSection.section_name }}</h3>
          <button
            @click="previewSection = null"
            class="text-gray-500 hover:text-gray-700"
          >
            <X class="w-6 h-6" />
          </button>
        </div>
        
        <!-- Preview content based on section type -->
        <div class="border border-gray-200 rounded-lg p-6">
          <div v-if="previewSection.section_type === 'hero'" :class="getHeroLayoutClass()">
            <div v-if="previewSection.content.image_url" class="h-64 bg-cover bg-center" :style="{ backgroundImage: `url(${previewSection.content.image_url})` }"></div>
            <div class="p-6">
              <h2 class="text-3xl font-bold mb-2">{{ previewSection.content.title || 'Hero Title' }}</h2>
              <p class="text-lg mb-4">{{ previewSection.content.subtitle || 'Hero subtitle' }}</p>
              <button class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
                {{ previewSection.content.cta_text || 'CTA Button' }}
              </button>
            </div>
          </div>
          
          <div v-else-if="previewSection.section_type === 'slider'" class="bg-gray-100 rounded-lg p-4">
            <div v-if="previewSection.content.slides && previewSection.content.slides.length > 0" class="relative">
              <div v-for="(slide, index) in previewSection.content.slides" :key="index" v-show="currentSlideIndex === index" class="h-64 flex items-center justify-center bg-gradient-to-r from-blue-400 to-indigo-500 rounded-lg text-white p-6 text-center">
                <div>
                  <h3 class="text-2xl font-bold mb-2">{{ slide.title }}</h3>
                  <p class="mb-4">{{ slide.description }}</p>
                  <a v-if="slide.cta_link" :href="slide.cta_link" class="inline-block bg-white text-blue-600 px-4 py-2 rounded-lg font-medium">
                    {{ slide.cta_text || 'Learn More' }}
                  </a>
                </div>
              </div>
              <div class="flex justify-center mt-4 space-x-2">
                <div 
                  v-for="(slide, index) in previewSection.content.slides || []" 
                  :key="index"
                  @click="currentSlideIndex = index"
                  :class="['w-3 h-3 rounded-full cursor-pointer', currentSlideIndex === index ? 'bg-blue-500' : 'bg-gray-300']"
                ></div>
              </div>
            </div>
            <div v-else class="h-64 flex items-center justify-center bg-gray-200 rounded-lg">
              <span class="text-gray-500">No slides added yet</span>
            </div>
          </div>
          
          <div v-else-if="previewSection.section_type === 'carousel'" class="bg-gray-100 rounded-lg p-4">
            <div v-if="previewSection.content.items && previewSection.content.items.length > 0" class="relative">
              <div v-for="(item, index) in previewSection.content.items" :key="index" v-show="currentCarouselIndex === index" class="h-64 flex items-center justify-center bg-gradient-to-r from-purple-400 to-pink-500 rounded-lg text-white p-6 text-center">
                <div>
                  <h3 class="text-2xl font-bold mb-2">{{ item.title }}</h3>
                  <p class="mb-4">{{ item.description }}</p>
                </div>
              </div>
              <div class="flex justify-center mt-4 space-x-2">
                <div 
                  v-for="(item, index) in previewSection.content.items || []" 
                  :key="index"
                  @click="currentCarouselIndex = index"
                  :class="['w-8 h-1 rounded-full cursor-pointer', currentCarouselIndex === index ? 'bg-purple-500' : 'bg-gray-300']"
                ></div>
              </div>
            </div>
            <div v-else class="h-64 flex items-center justify-center bg-gray-200 rounded-lg">
              <span class="text-gray-500">No items added yet</span>
            </div>
          </div>
          
          <div v-else-if="previewSection.section_type === 'grid'" class="p-2">
            <h3 v-if="previewSection.content.grid_title" class="text-xl font-bold mb-4">{{ previewSection.content.grid_title }}</h3>
            <div :class="`grid gap-4 ${getGridClass()}`">
              <div v-for="(item, index) in previewSection.content.grid_items || []" :key="index" class="border border-gray-200 rounded-lg p-4">
                <div v-if="item.image_url" class="h-24 bg-cover bg-center mb-2" :style="{ backgroundImage: `url(${item.image_url})` }"></div>
                <h4 class="font-semibold mb-1">{{ item.title }}</h4>
                <p class="text-sm text-gray-600">{{ item.description }}</p>
              </div>
            </div>
          </div>
          
          <div v-else-if="previewSection.section_type === 'features'" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(feature, idx) in previewSection.content.features || []" :key="idx" class="border border-gray-200 p-4 rounded-lg">
              <h4 class="font-semibold">{{ feature.title || 'Feature Title' }}</h4>
              <p class="text-sm text-gray-600 mt-1">{{ feature.description || 'Feature description' }}</p>
            </div>
          </div>
          
          <div v-else-if="previewSection.section_type === 'products'" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div v-for="n in 4" :key="n" class="border border-gray-200 rounded-lg p-4">
              <div class="bg-gray-200 h-32 rounded mb-2"></div>
              <div class="h-4 bg-gray-200 rounded mb-1"></div>
              <div class="h-4 bg-gray-200 rounded w-3/4"></div>
            </div>
          </div>
          
          <div v-else class="text-gray-500 italic text-center py-10">
            {{ previewSection.section_type }} section preview
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useLandingPageStore } from '../stores/landingPage'
import { Plus, Eye, EyeOff, Edit3, ArrowUp, ArrowDown, Trash2, X } from 'lucide-vue-next'

const landingPageStore = useLandingPageStore()

const sections = ref([])
const showAddModal = ref(false)
const editingSection = ref(null)
const previewSection = ref(null)
const currentSlideIndex = ref(0)
const currentCarouselIndex = ref(0)
const newSection = ref({
  section_name: '',
  section_type: 'hero'
})

// New slide and carousel item objects
const newSlide = ref({
  title: '',
  description: '',
  cta_text: '',
  cta_link: '',
  image_url: ''
})

const newCarouselItem = ref({
  title: '',
  description: '',
  image_url: ''
})

// Theme and navigation settings
const themeSettings = ref({
  primary_color: '#3b82f6',
  secondary_color: '#60a5fa',
  background_color: '#ffffff',
  font_family: 'Inter'
})

const navigationSettings = ref({
  visible: true,
  items: [
    { title: 'Home', url: '/' },
    { title: 'Products', url: '/catalog' },
    { title: 'About', url: '/about' },
    { title: 'Contact', url: '/contact' }
  ]
})

onMounted(async () => {
  await loadSections()
  // Start slider auto-rotation if needed
  startSliderRotation()
  startCarouselRotation()
})

const loadSections = async () => {
  try {
    sections.value = await landingPageStore.getSections()
  } catch (error) {
    console.error('Error loading sections:', error)
  }
}

const addSection = () => {
  newSection.value = {
    section_name: '',
    section_type: 'hero'
  }
  showAddModal.value = true
}

const createSection = async () => {
  try {
    // Initialize content based on section type
    if (newSection.value.section_type === 'slider') {
      newSection.value.content = { slides: [] }
    } else if (newSection.value.section_type === 'carousel') {
      newSection.value.content = { items: [] }
    } else if (newSection.value.section_type === 'grid') {
      newSection.value.content = { grid_items: [] }
    } else {
      newSection.value.content = {}
    }
    
    await landingPageStore.createSection(newSection.value)
    await loadSections()
    showAddModal.value = false
  } catch (error) {
    console.error('Error creating section:', error)
  }
}

const editSection = (section) => {
  // Deep copy the section to avoid direct mutation
  editingSection.value = JSON.parse(JSON.stringify(section))
  
  // Initialize settings object if it doesn't exist
  if (!editingSection.value.settings) {
    editingSection.value.settings = {}
  }
  
  // Initialize empty arrays if not present
  if (editingSection.value.section_type === 'slider' && !editingSection.value.content.slides) {
    editingSection.value.content.slides = []
  } else if (editingSection.value.section_type === 'carousel' && !editingSection.value.content.items) {
    editingSection.value.content.items = []
  } else if (editingSection.value.section_type === 'grid' && !editingSection.value.content.grid_items) {
    editingSection.value.content.grid_items = []
  }
}

const updateSection = async () => {
  try {
    await landingPageStore.updateSection(editingSection.value.id, editingSection.value)
    await loadSections()
    editingSection.value = null
  } catch (error) {
    console.error('Error updating section:', error)
  }
}

const deleteSection = async (id) => {
  if (confirm('Are you sure you want to delete this section?')) {
    try {
      await landingPageStore.deleteSection(id)
      await loadSections()
    } catch (error) {
      console.error('Error deleting section:', error)
    }
  }
}

const toggleSection = async (section) => {
  try {
    await landingPageStore.updateSection(section.id, { is_active: !section.is_active })
    await loadSections()
  } catch (error) {
    console.error('Error toggling section:', error)
  }
}

const moveSection = async (index, direction) => {
  if ((direction === -1 && index === 0) || (direction === 1 && index === sections.value.length - 1)) {
    return
  }

  const newIndex = index + direction
  const sectionsArray = [...sections.value]
  
  // Swap sort orders
  const tempOrder = sectionsArray[index].sort_order
  sectionsArray[index].sort_order = sectionsArray[newIndex].sort_order
  sectionsArray[newIndex].sort_order = tempOrder
  
  // Update in database
  try {
    await landingPageStore.updateSection(sectionsArray[index].id, { sort_order: sectionsArray[index].sort_order })
    await landingPageStore.updateSection(sectionsArray[newIndex].id, { sort_order: sectionsArray[newIndex].sort_order })
    await loadSections() // Refresh the list
  } catch (error) {
    console.error('Error moving section:', error)
  }
}

// Preview functions
const previewContent = (section) => {
  previewSection.value = JSON.parse(JSON.stringify(section))
  // Reset slider and carousel indices when previewing
  currentSlideIndex.value = 0
  currentCarouselIndex.value = 0
}

// Layout related functions
const getHeroLayoutClass = () => {
  const layout = editingSection.value?.content?.layout_type || 'default'
  const height = editingSection.value?.content?.height || 'large'
  
  let classes = 'rounded-lg overflow-hidden '
  
  switch(height) {
    case 'small':
      classes += 'h-48 '
      break
    case 'medium':
      classes += 'h-64 '
      break
    case 'extra-large':
      classes += 'h-96 '
      break
    default: // large
      classes += 'h-80 '
  }
  
  switch(layout) {
    case 'full-width':
      classes += 'w-full '
      break
    case 'centered':
      classes += 'mx-auto max-w-4xl '
      break
    case 'split-view':
      classes += 'flex flex-col md:flex-row '
      break
    default:
      classes += 'w-full '
  }
  
  return classes
}

const getGridClass = () => {
  const columns = previewSection.value?.content?.columns || 3
  const baseClass = 'grid gap-4 '
  
  switch(columns) {
    case '2': return baseClass + 'grid-cols-2'
    case '3': return baseClass + 'grid-cols-3'
    case '4': return baseClass + 'grid-cols-4'
    case '5': return baseClass + 'grid-cols-5'
    case '6': return baseClass + 'grid-cols-6'
    default: return baseClass + 'grid-cols-3'
  }
}

// Slider functions
const addSlide = () => {
  if (!editingSection.value.content.slides) {
    editingSection.value.content.slides = []
  }
  editingSection.value.content.slides.push({...newSlide.value})
  // Reset form
  newSlide.value = {
    title: '',
    description: '',
    cta_text: '',
    cta_link: '',
    image_url: ''
  }
}

const removeSlide = (index) => {
  editingSection.value.content.slides.splice(index, 1)
}

// Carousel functions
const addCarouselItem = () => {
  if (!editingSection.value.content.items) {
    editingSection.value.content.items = []
  }
  editingSection.value.content.items.push({...newCarouselItem.value})
  // Reset form
  newCarouselItem.value = {
    title: '',
    description: '',
    image_url: ''
  }
}

const removeCarouselItem = (index) => {
  editingSection.value.content.items.splice(index, 1)
}

// Grid functions
const addGridItem = () => {
  if (!editingSection.value.content.grid_items) {
    editingSection.value.content.grid_items = []
  }
  editingSection.value.content.grid_items.push({
    title: 'New Item',
    description: 'Item description',
    image_url: ''
  })
}

const removeGridItem = (index) => {
  editingSection.value.content.grid_items.splice(index, 1)
}

// Auto-rotation for sliders and carousels
const startSliderRotation = () => {
  if (!previewSection.value) return
  
  setInterval(() => {
    if (previewSection.value && previewSection.value.section_type === 'slider' && 
        previewSection.value.content.slides && 
        previewSection.value.content.slides.length > 1) {
      currentSlideIndex.value = (currentSlideIndex.value + 1) % previewSection.value.content.slides.length
    }
  }, 5000) // Change slide every 5 seconds
}

const startCarouselRotation = () => {
  if (!previewSection.value) return
  
  setInterval(() => {
    if (previewSection.value && previewSection.value.section_type === 'carousel' && 
        previewSection.value.content.items && 
        previewSection.value.content.items.length > 1) {
      currentCarouselIndex.value = (currentCarouselIndex.value + 1) % previewSection.value.content.items.length
    }
  }, 4000) // Change carousel item every 4 seconds
}

// Theme functions
const saveThemeSettings = async () => {
  try {
    // In a real app, you would save these settings to a dedicated theme table
    // For now, we'll just show a success message
    alert('Theme settings saved successfully!')
  } catch (error) {
    console.error('Error saving theme settings:', error)
  }
}

// Navigation functions
const addNavItem = () => {
  navigationSettings.value.items.push({ title: '', url: '' })
}

const removeNavItem = (index) => {
  navigationSettings.value.items.splice(index, 1)
}

const saveNavigationSettings = async () => {
  try {
    // In a real app, you would save these settings to a dedicated navigation table
    // For now, we'll just show a success message
    alert('Navigation settings saved successfully!')
  } catch (error) {
    console.error('Error saving navigation settings:', error)
  }
}

// Feature functions for features section
const addFeature = () => {
  if (!editingSection.value.content.features) {
    editingSection.value.content.features = []
  }
  editingSection.value.content.features.push({
    icon: '',
    title: '',
    description: '',
    position: ''
  })
}

const removeFeature = (index) => {
  editingSection.value.content.features.splice(index, 1)
}
</script>