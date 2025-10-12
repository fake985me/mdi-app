<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-bold text-gray-900">Page Builder</h1>
        <p class="text-gray-600">Create and manage all your website pages with the unified page builder</p>
        <div class="mt-2 text-sm text-blue-600 bg-blue-50 p-2 rounded-md">
          <Info class="w-4 h-4 inline mr-1" />
          Tip: Select 'Home Page' type to create your homepage, or choose 'Regular Page' for other pages
        </div>
      </div>
      <div class="flex space-x-3">
        <button
          @click="useTemplate"
          class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2"
        >
          <Layout class="w-5 h-5" />
          <span>Use Template</span>
        </button>
        <button
          @click="savePage"
          class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2"
        >
          <Save class="w-5 h-5" />
          <span>Save Page</span>
        </button>
        <button
          @click="previewPage"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2"
        >
          <Eye class="w-5 h-5" />
          <span>Preview</span>
        </button>
      </div>
    </div>

    <!-- Page Title and Settings -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Page Title</label>
          <input
            v-model="currentPage.title"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Enter page title"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
          <input
            v-model="currentPage.slug"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="page-slug"
          />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
          <textarea
            v-model="currentPage.meta_description"
            rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Brief description for search engines"
          ></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
          <input
            v-model="currentPage.meta_keywords"
            type="text"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="keyword1, keyword2, keyword3"
          />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
          <input
            v-model="currentPage.featured_image"
            type="url"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="https://example.com/image.jpg"
          />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">Page Description</label>
          <textarea
            v-model="currentPage.description"
            rows="2"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            placeholder="Brief description of the page"
          ></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Page Type</label>
          <select
            v-model="selectedPageType"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="regular">Regular Page</option>
            <option value="home">Home Page</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
          <select
            v-model="currentPage.is_active"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option :value="true">Published</option>
            <option :value="false">Draft</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Page Layout</label>
          <select
            v-model="currentPage.settings.layout"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="full-width">Full Width</option>
            <option value="sidebar-left">Sidebar Left</option>
            <option value="sidebar-right">Sidebar Right</option>
            <option value="boxed">Boxed Content</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Layout Grid and Section Controls -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Available Elements -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sticky top-4">
          <h3 class="font-semibold text-gray-900 mb-4">Add Elements</h3>
          <div class="space-y-2">
            <div
              v-for="element in availableElements"
              :key="element.type"
              class="p-3 border border-gray-200 rounded-md cursor-move hover:bg-gray-50 transition-colors"
              draggable="true"
              @dragstart="startDrag($event, element)"
            >
              <div class="flex items-center space-x-3">
                <component :is="element.icon" class="w-5 h-5 text-gray-500" />
                <span class="text-sm font-medium">{{ element.name }}</span>
              </div>
            </div>
          </div>

          <!-- Grid Settings -->
          <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="font-medium text-gray-900 mb-3">Grid Settings</h4>
            <div class="space-y-3">
              <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Columns</label>
                <select
                  v-model="gridSettings.columns"
                  class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                >
                  <option value="1">1 Column</option>
                  <option value="2">2 Columns</option>
                  <option value="3">3 Columns</option>
                  <option value="4">4 Columns</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Gap</label>
                <input
                  v-model.number="gridSettings.gap"
                  type="number"
                  min="0"
                  max="12"
                  class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content Area -->
      <div class="lg:col-span-3">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
          <h3 class="font-semibold text-gray-900 mb-4">Page Content</h3>
          
          <!-- Drag and Drop Zone -->
          <div
            class="min-h-96 border-2 border-dashed border-gray-300 rounded-lg p-4"
            @dragover.prevent
            @drop="onDrop"
            :style="{ 
              display: gridSettings.columns > 1 ? 'grid' : 'block',
              gridTemplateColumns: gridSettings.columns > 1 ? `repeat(${gridSettings.columns}, 1fr)` : 'auto',
              gap: `${gridSettings.gap}rem`
            }"
          >
            <div
              v-for="(section, index) in currentPage.content"
              :key="index"
              class="relative group border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
              :class="{
                'col-span-1': section.settings?.colSpan === 1,
                'col-span-2': section.settings?.colSpan === 2,
                'col-span-3': section.settings?.colSpan === 3,
                'col-span-4': section.settings?.colSpan === 4
              }"
            >
              <!-- Section Controls -->
              <div class="absolute -top-2 -right-2 flex space-x-1 bg-white rounded-full shadow-sm p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                <button
                  @click="editSection(section)"
                  class="p-1 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded"
                >
                  <Edit3 class="w-3 h-3" />
                </button>
                <button
                  @click="duplicateSection(index)"
                  class="p-1 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded"
                >
                  <Copy class="w-3 h-3" />
                </button>
                <button
                  @click="deleteSection(index)"
                  class="p-1 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded"
                >
                  <Trash2 class="w-3 h-3" />
                </button>
              </div>

              <!-- Section Content Preview -->
              <div class="flex items-start space-x-3">
                <component 
                  :is="getSectionIcon(section.type)" 
                  class="w-5 h-5 text-gray-400 mt-0.5" 
                />
                <div class="flex-1">
                  <h4 class="font-medium text-gray-900 capitalize">{{ section.type.replace('_', ' ') }}</h4>
                  <p class="text-xs text-gray-500 mt-1">{{ getSectionPreview(section) }}</p>
                </div>
              </div>

              <!-- Section Settings -->
              <div class="mt-3 pt-3 border-t border-gray-100">
                <div class="flex flex-wrap gap-2 text-xs">
                  <span v-if="section.settings?.columns" class="px-2 py-1 bg-gray-100 rounded">
                    {{ section.settings.columns }} cols
                  </span>
                  <span v-if="section.settings?.layout" class="px-2 py-1 bg-gray-100 rounded">
                    {{ section.settings.layout }}
                  </span>
                  <span v-if="section.settings?.background" class="px-2 py-1 bg-gray-100 rounded">
                    Background
                  </span>
                </div>
              </div>
            </div>

            <div v-if="currentPage.content.length === 0" class="text-center py-12 text-gray-500">
              <p>Drag elements here to start building your page</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section Editor Modal -->
    <div v-if="editingSection" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
          Edit {{ editingSection.type.replace('_', ' ') }} Section
        </h3>

        <div class="space-y-6">
          <!-- General Section Settings -->
          <div>
            <h4 class="font-medium text-gray-900 mb-3">Section Settings</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Column Span</label>
                <select
                  v-model="editingSection.settings.colSpan"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                >
                  <option :value="1">1 Column</option>
                  <option :value="2">2 Columns</option>
                  <option :value="3">3 Columns</option>
                  <option :value="4">4 Columns</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section ID</label>
                <input
                  v-model="editingSection.id"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="unique-section-id"
                />
              </div>
            </div>
          </div>

          <!-- Content Based on Section Type -->
          <!-- Hero Section -->
          <div v-if="editingSection.type === 'hero'">
            <h4 class="font-medium text-gray-900 mb-3">Hero Content</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <input
                  v-model="editingSection.content.subtitle"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Background Image</label>
                <input
                  v-model="editingSection.content.image_url"
                  type="url"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="https://example.com/image.jpg"
                />
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">CTA Button Text</label>
                  <input
                    v-model="editingSection.content.cta_text"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Button text"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">CTA Button URL</label>
                  <input
                    v-model="editingSection.content.cta_link"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    placeholder="URL"
                  />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Background Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.background_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.background_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Text Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.text_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.text_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content with Image Section -->
          <div v-if="editingSection.type === 'content_with_image'">
            <h4 class="font-medium text-gray-900 mb-3">Content with Image</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea
                  v-model="editingSection.content.content"
                  rows="4"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter content here..."
                ></textarea>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                <input
                  v-model="editingSection.content.image_url"
                  type="url"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="https://example.com/image.jpg"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image Position</label>
                <div class="flex space-x-4">
                  <label class="flex items-center">
                    <input
                      type="radio"
                      v-model="editingSection.settings.image_position"
                      value="left"
                      class="mr-2"
                    />
                    Left
                  </label>
                  <label class="flex items-center">
                    <input
                      type="radio"
                      v-model="editingSection.settings.image_position"
                      value="right"
                      class="mr-2"
                    />
                    Right
                  </label>
                  <label class="flex items-center">
                    <input
                      type="radio"
                      v-model="editingSection.settings.image_position"
                      value="top"
                      class="mr-2"
                    />
                    Top
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Carousel/Slider Section -->
          <div v-if="editingSection.type === 'carousel'">
            <h4 class="font-medium text-gray-900 mb-3">Carousel Settings</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slides</label>
                <div v-for="(slide, idx) in editingSection.content.slides || []" :key="idx" class="border border-gray-200 p-4 rounded-md mb-3">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Image URL</label>
                      <input
                        v-model="slide.image_url"
                        type="url"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://example.com/image.jpg"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Alt Text</label>
                      <input
                        v-model="slide.alt_text"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Image description"
                      />
                    </div>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Title</label>
                      <input
                        v-model="slide.title"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Slide title"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Subtitle</label>
                      <input
                        v-model="slide.subtitle"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Slide subtitle"
                      />
                    </div>
                  </div>
                  <div>
                    <label class="block text-xs text-gray-500 mb-1">Description</label>
                    <textarea
                      v-model="slide.description"
                      rows="2"
                      class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Slide description"
                    ></textarea>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Button Text</label>
                      <input
                        v-model="slide.button_text"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Button text"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Button URL</label>
                      <input
                        v-model="slide.button_url"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Button URL"
                      />
                    </div>
                  </div>
                  <button
                    @click="removeSlide(idx)"
                    class="text-red-600 text-xs mt-2 flex items-center"
                  >
                    <Trash2 class="w-3 h-3 mr-1" /> Remove Slide
                  </button>
                </div>
                <button
                  @click="addSlide"
                  class="text-blue-600 text-sm flex items-center"
                >
                  <Plus class="w-4 h-4 mr-1" /> Add Slide
                </button>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Autoplay</label>
                  <button
                    @click="editingSection.settings.autoplay = !editingSection.settings.autoplay"
                    :class="['relative inline-flex h-6 w-11 items-center rounded-full transition-colors', editingSection.settings.autoplay ? 'bg-blue-600' : 'bg-gray-200']"
                  >
                    <span
                      :class="['inline-block h-4 w-4 transform rounded-full bg-white transition-transform', editingSection.settings.autoplay ? 'translate-x-6' : 'translate-x-1']"
                    />
                  </button>
                </div>
                <div v-if="editingSection.settings.autoplay">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Autoplay Speed (ms)</label>
                  <input
                    v-model.number="editingSection.settings.autoplay_speed"
                    type="number"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Slider Section -->
          <div v-if="editingSection.type === 'slider'">
            <h4 class="font-medium text-gray-900 mb-3">Slider Settings</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slides</label>
                <div v-for="(slide, idx) in editingSection.content.slides || []" :key="idx" class="border border-gray-200 p-4 rounded-md mb-3">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Image URL</label>
                      <input
                        v-model="slide.image_url"
                        type="url"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://example.com/image.jpg"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Alt Text</label>
                      <input
                        v-model="slide.alt_text"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Image description"
                      />
                    </div>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Title</label>
                      <input
                        v-model="slide.title"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Slide title"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Subtitle</label>
                      <input
                        v-model="slide.subtitle"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Slide subtitle"
                      />
                    </div>
                  </div>
                  <div>
                    <label class="block text-xs text-gray-500 mb-1">Description</label>
                    <textarea
                      v-model="slide.description"
                      rows="2"
                      class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Slide description"
                    ></textarea>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Button Text</label>
                      <input
                        v-model="slide.button_text"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Button text"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Button URL</label>
                      <input
                        v-model="slide.button_url"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Button URL"
                      />
                    </div>
                  </div>
                  <button
                    @click="removeSlide(idx)"
                    class="text-red-600 text-xs mt-2 flex items-center"
                  >
                    <Trash2 class="w-3 h-3 mr-1" /> Remove Slide
                  </button>
                </div>
                <button
                  @click="addSlide"
                  class="text-blue-600 text-sm flex items-center"
                >
                  <Plus class="w-4 h-4 mr-1" /> Add Slide
                </button>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Autoplay</label>
                  <button
                    @click="editingSection.settings.autoplay = !editingSection.settings.autoplay"
                    :class="['relative inline-flex h-6 w-11 items-center rounded-full transition-colors', editingSection.settings.autoplay ? 'bg-blue-600' : 'bg-gray-200']"
                  >
                    <span
                      :class="['inline-block h-4 w-4 transform rounded-full bg-white transition-transform', editingSection.settings.autoplay ? 'translate-x-6' : 'translate-x-1']"
                    />
                  </button>
                </div>
                <div v-if="editingSection.settings.autoplay">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Autoplay Speed (ms)</label>
                  <input
                    v-model.number="editingSection.settings.autoplay_speed"
                    type="number"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Grid Section -->
          <div v-if="editingSection.type === 'grid'">
            <h4 class="font-medium text-gray-900 mb-3">Grid Layout Settings</h4>
            <div class="space-y-4">
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
                  <option :value="2">2 Columns</option>
                  <option :value="3">3 Columns</option>
                  <option :value="4">4 Columns</option>
                  <option :value="5">5 Columns</option>
                  <option :value="6">6 Columns</option>
                </select>
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

          <!-- Testimonials Section -->
          <div v-if="editingSection.type === 'testimonials'">
            <h4 class="font-medium text-gray-900 mb-3">Testimonials Settings</h4>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Testimonials</label>
                <div v-for="(testimonial, idx) in editingSection.content.testimonials || []" :key="idx" class="border border-gray-200 p-4 rounded-md mb-3">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Customer Name</label>
                      <input
                        v-model="testimonial.name"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Customer Name"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Position</label>
                      <input
                        v-model="testimonial.position"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Position"
                      />
                    </div>
                  </div>
                  <div>
                    <label class="block text-xs text-gray-500 mb-1">Testimonial Content</label>
                    <textarea
                      v-model="testimonial.content"
                      rows="2"
                      class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Testimonial content"
                    ></textarea>
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Rating</label>
                      <select
                        v-model.number="testimonial.rating"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                      >
                        <option :value="1">1 Star</option>
                        <option :value="2">2 Stars</option>
                        <option :value="3">3 Stars</option>
                        <option :value="4">4 Stars</option>
                        <option :value="5">5 Stars</option>
                      </select>
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Image URL</label>
                      <input
                        v-model="testimonial.image_url"
                        type="url"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Image URL"
                      />
                    </div>
                  </div>
                  <button
                    @click="removeTestimonial(idx)"
                    class="text-red-600 text-xs mt-2 flex items-center"
                  >
                    <Trash2 class="w-3 h-3 mr-1" /> Remove Testimonial
                  </button>
                </div>
                <button
                  @click="addTestimonial"
                  class="text-blue-600 text-sm flex items-center"
                >
                  <Plus class="w-4 h-4 mr-1" /> Add Testimonial
                </button>
              </div>
            </div>
          </div>

          <!-- Call to Action Section -->
          <div v-if="editingSection.type === 'cta'">
            <h4 class="font-medium text-gray-900 mb-3">Call to Action Settings</h4>
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
                  <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                  <input
                    v-model="editingSection.content.subtitle"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">CTA Button Text</label>
                  <input
                    v-model="editingSection.content.cta_text"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">CTA Button URL</label>
                  <input
                    v-model="editingSection.content.cta_link"
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  />
                </div>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Background Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.background_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.background_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Text Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.text_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.text_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Products Section -->
          <div v-if="editingSection.type === 'products'">
            <h4 class="font-medium text-gray-900 mb-3">Products Section</h4>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Display Settings</label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-xs text-gray-500 mb-1">Number of Products</label>
                    <input
                      v-model.number="editingSection.settings.product_count"
                      type="number"
                      min="1"
                      max="20"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                  <div>
                    <label class="block text-xs text-gray-500 mb-1">Layout Style</label>
                    <select
                      v-model="editingSection.settings.layout_style"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    >
                      <option value="grid">Grid</option>
                      <option value="list">List</option>
                      <option value="carousel">Carousel</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Navigation Section -->
          <div v-if="editingSection.type === 'navigation'">
            <h4 class="font-medium text-gray-900 mb-3">Navigation Section</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Navigation Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Website name or logo"
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Menu Items</label>
                <div v-for="(item, idx) in editingSection.content.menu_items || []" :key="idx" class="border border-gray-200 p-4 rounded-md mb-3">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Item Label</label>
                      <input
                        v-model="item.label"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Menu item"
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">URL</label>
                      <input
                        v-model="item.url"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="/path"
                      />
                    </div>
                  </div>
                  <button
                    @click="removeMenuItem(idx)"
                    class="text-red-600 text-xs mt-2 flex items-center"
                  >
                    <Trash2 class="w-3 h-3 mr-1" /> Remove Item
                  </button>
                </div>
                <button
                  @click="addMenuItem"
                  class="text-blue-600 text-sm flex items-center"
                >
                  <Plus class="w-4 h-4 mr-1" /> Add Menu Item
                </button>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.background_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.background_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.text_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.text_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer Section -->
          <div v-if="editingSection.type === 'footer'">
            <h4 class="font-medium text-gray-900 mb-3">Footer Section</h4>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Footer Title</label>
                <input
                  v-model="editingSection.content.title"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Company name or logo"
                />
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Footer Content</label>
                <textarea
                  v-model="editingSection.content.content"
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Footer text, copyright, etc."
                ></textarea>
              </div>
              
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Social Links</label>
                <div v-for="(link, idx) in editingSection.content.social_links || []" :key="idx" class="border border-gray-200 p-4 rounded-md mb-3">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">Platform</label>
                      <input
                        v-model="link.platform"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Facebook, Twitter, etc."
                      />
                    </div>
                    <div>
                      <label class="block text-xs text-gray-500 mb-1">URL</label>
                      <input
                        v-model="link.url"
                        type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://social-link.com"
                      />
                    </div>
                  </div>
                  <button
                    @click="removeSocialLink(idx)"
                    class="text-red-600 text-xs mt-2 flex items-center"
                  >
                    <Trash2 class="w-3 h-3 mr-1" /> Remove Link
                  </button>
                </div>
                <button
                  @click="addSocialLink"
                  class="text-blue-600 text-sm flex items-center"
                >
                  <Plus class="w-4 h-4 mr-1" /> Add Social Link
                </button>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.background_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.background_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                  <div class="flex items-center space-x-3">
                    <input
                      v-model="editingSection.settings.text_color"
                      type="color"
                      class="w-12 h-10 rounded border border-gray-300"
                    />
                    <input
                      v-model="editingSection.settings.text_color"
                      type="text"
                      class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Other section types can be added here -->
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
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
          >
            Save Section
          </button>
        </div>
      </div>
    </div>
    
    <!-- Template Selection Modal -->
    <div v-if="showTemplateModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Select a Template</h3>
          <button
            @click="showTemplateModal = false"
            class="text-gray-500 hover:text-gray-700"
          >
            <X class="w-6 h-6" />
          </button>
        </div>
        
        <div v-if="availableTemplates.length === 0" class="text-center py-12">
          <FileText class="mx-auto h-12 w-12 text-gray-400" />
          <h3 class="mt-2 text-sm font-medium text-gray-900">No templates</h3>
          <p class="mt-1 text-sm text-gray-500">No templates available to use.</p>
        </div>
        
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="template in availableTemplates"
            :key="template.id"
            class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow cursor-pointer"
            @click="applyTemplate(template)"
          >
            <div class="flex justify-between items-start mb-2">
              <h4 class="font-medium text-gray-900">{{ template.name }}</h4>
              <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                {{ template.category }}
              </span>
            </div>
            <p class="text-sm text-gray-500 mb-3" v-if="template.description">
              {{ template.description }}
            </p>
            <div class="text-xs text-gray-500">
              {{ template.content?.length || 0 }} sections
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { usePageStore } from '../stores/page'
import { useTemplateStore } from '../stores/template'
import { 
  Plus, 
  Edit3, 
  Trash2, 
  Copy, 
  Save, 
  Eye, 
  Type, 
  Image, 
  Layout, 
  Sliders, 
  Square, 
  Columns, 
  Grid3X3, 
  Play, 
  FileText, 
  Code, 
  Users,
  Star,
  X,
  Info
} from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const pageStore = usePageStore()
const templateStore = useTemplateStore()

const currentPage = ref({
  title: '',
  slug: '',
  content: [],
  settings: {
    layout: 'full-width'
  },
  is_active: true
})

const selectedPageType = ref('regular')

// Watch for changes in page type to update title and slug
watch(selectedPageType, (newType) => {
  if (newType === 'home') {
    currentPage.value.title = 'Home'
    currentPage.value.slug = 'home'
  } else if (!isEditing.value && currentPage.value.slug === 'home') {
    // If changing from home to regular and it's a new page, reset the slug
    currentPage.value.slug = 'new-page-' + Date.now()
  }
})

const isEditing = ref(false)
const showTemplateModal = ref(false)
const availableTemplates = ref([])

const gridSettings = ref({
  columns: 1,
  gap: 2
})

const editingSection = ref(null)

const availableElements = [
  {
    type: 'hero',
    name: 'Hero Section',
    icon: Sliders,
    defaultContent: {
      title: 'Hero Title',
      subtitle: 'Hero Subtitle',
      image_url: '',
      cta_text: 'Get Started',
      cta_link: '#'
    },
    defaultSettings: {
      colSpan: 1,
      background_color: '#1e40af',
      text_color: '#ffffff'
    }
  },
  {
    type: 'content_with_image',
    name: 'Content with Image',
    icon: Image,
    defaultContent: {
      title: 'Content Title',
      content: 'Content description...',
      image_url: ''
    },
    defaultSettings: {
      colSpan: 1,
      image_position: 'right'
    }
  },
  {
    type: 'carousel',
    name: 'Carousel/Slider',
    icon: Play,
    defaultContent: {
      title: 'Our Products',
      slides: []
    },
    defaultSettings: {
      colSpan: 1,
      autoplay: false,
      autoplay_speed: 5000
    }
  },
  {
    type: 'text_block',
    name: 'Text Block',
    icon: Type,
    defaultContent: {
      title: 'Text Block Title',
      content: 'Text content...'
    },
    defaultSettings: {
      colSpan: 1
    }
  },
  {
    type: 'grid_layout',
    name: 'Grid Layout',
    icon: Grid3X3,
    defaultContent: {
      title: 'Grid Section',
      items: []
    },
    defaultSettings: {
      colSpan: 1,
      columns: 3
    }
  },
  {
    type: 'features',
    name: 'Features',
    icon: Star,
    defaultContent: {
      title: 'Features',
      features: []
    },
    defaultSettings: {
      colSpan: 1,
      layout: 'cards'
    }
  },
  {
    type: 'slider',
    name: 'Slider',
    icon: Play,
    defaultContent: {
      title: 'Image Slider',
      slides: []
    },
    defaultSettings: {
      colSpan: 1,
      autoplay: false,
      autoplay_speed: 5000
    }
  },
  {
    type: 'grid',
    name: 'Grid Layout',
    icon: Grid3X3,
    defaultContent: {
      grid_title: 'Grid Title',
      columns: 3,
      grid_items: []
    },
    defaultSettings: {
      colSpan: 1,
      layout: 'card'
    }
  },
  {
    type: 'testimonials',
    name: 'Testimonials',
    icon: Users,
    defaultContent: {
      title: 'What Our Customers Say',
      subtitle: 'Hear from our satisfied customers',
      testimonials: []
    },
    defaultSettings: {
      colSpan: 1,
      show_ratings: true
    }
  },
  {
    type: 'cta',
    name: 'Call to Action',
    icon: Layout,
    defaultContent: {
      title: 'Ready to get started?',
      subtitle: 'Join thousands of satisfied customers today',
      cta_text: 'Sign Up Now',
      cta_link: '/register'
    },
    defaultSettings: {
      colSpan: 1,
      background_color: '#3b82f6',
      text_color: '#ffffff'
    }
  },
  {
    type: 'products',
    name: 'Product Showcase',
    icon: Square,
    defaultContent: {
      title: 'Featured Products',
      subtitle: 'Check out our most popular items',
      product_count: 8
    },
    defaultSettings: {
      colSpan: 1,
      layout_style: 'grid',
      product_count: 8
    }
  },
  {
    type: 'navigation',
    name: 'Navigation Bar',
    icon: Layout,
    defaultContent: {
      title: 'Website Name',
      menu_items: [
        { label: 'Home', url: '/' },
        { label: 'About', url: '/about' },
        { label: 'Contact', url: '/contact' }
      ]
    },
    defaultSettings: {
      colSpan: 1,
      background_color: '#ffffff',
      text_color: '#1f2937'
    }
  },
  {
    type: 'footer',
    name: 'Footer',
    icon: Layout,
    defaultContent: {
      title: 'Company Name',
      content: '© 2025 Company Name. All rights reserved.',
      social_links: [
        { platform: 'Facebook', url: '#' },
        { platform: 'Twitter', url: '#' },
        { platform: 'Instagram', url: '#' }
      ]
    },
    defaultSettings: {
      colSpan: 1,
      background_color: '#1f2937',
      text_color: '#ffffff'
    }
  }
]

onMounted(async () => {
  // Load available templates for use
  try {
    availableTemplates.value = await templateStore.getActiveTemplates()
  } catch (error) {
    console.error('Error loading templates:', error)
  }
  
  if (route.params.id) {
    // Editing existing page
    isEditing.value = true
    try {
      const page = await pageStore.getPage(route.params.id)
      currentPage.value = {
        ...page,
        content: Array.isArray(page.content) ? page.content : []
      }
      // Set page type based on slug
      selectedPageType.value = currentPage.value.slug === 'home' ? 'home' : 'regular'
    } catch (error) {
      console.error('Error loading page:', error)
      // Display a more user-friendly message instead of an alert
      if (error.message.includes('404')) {
        console.warn('Page not found, switching to create mode')
        isEditing.value = false
        currentPage.value = {
          title: 'New Page',
          slug: 'new-page',
          content: [],
          settings: {
            layout: 'full-width'
          },
          is_active: true
        }
        selectedPageType.value = 'regular'
      } else {
        alert('Error loading page: ' + error.message)
      }
    }
  } else {
    // Check if creating from a template
    const templateId = route.query.template
    if (templateId) {
      try {
        const template = await templateStore.getTemplate(templateId)
        currentPage.value = {
          title: template.name,
          slug: template.slug + '-' + Date.now(),
          content: [...template.content] || [],
          settings: { ...template.settings } || {},
          is_active: true
        }
        isEditing.value = false
        selectedPageType.value = 'regular'
      } catch (error) {
        console.error('Error loading template:', error)
        // Fallback to default
        currentPage.value = {
          title: 'New Page',
          slug: 'new-page',
          content: [],
          settings: {
            layout: 'full-width'
          },
          is_active: true
        }
        selectedPageType.value = 'regular'
      }
    } else {
      // Creating new page
      currentPage.value = {
        title: 'New Page',
        slug: 'new-page',
        content: [],
        settings: {
          layout: 'full-width'
        },
        is_active: true
      }
      selectedPageType.value = 'regular'
    }
  }
})

const useTemplate = () => {
  showTemplateModal.value = true
  // Load templates if not already loaded
  if (availableTemplates.value.length === 0) {
    loadTemplates()
  }
}

const loadTemplates = async () => {
  try {
    availableTemplates.value = await templateStore.getActiveTemplates()
  } catch (error) {
    console.error('Error loading templates:', error)
  }
}

const applyTemplate = (template) => {
  currentPage.value.content = [...template.content] || []
  currentPage.value.settings = { ...template.settings } || {}
  currentPage.value.title = template.name
  currentPage.value.slug = template.slug + '-' + Date.now()
  showTemplateModal.value = false
}

const startDrag = (event, element) => {
  event.dataTransfer.setData('element', JSON.stringify(element))
}

const onDrop = (event) => {
  event.preventDefault()
  const elementData = JSON.parse(event.dataTransfer.getData('element'))
  
  const newSection = {
    id: `section-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`,
    type: elementData.type,
    content: { ...elementData.defaultContent },
    settings: { ...elementData.defaultSettings }
  }
  
  currentPage.value.content.push(newSection)
}

const editSection = (section) => {
  editingSection.value = JSON.parse(JSON.stringify(section))
}

const updateSection = () => {
  const index = currentPage.value.content.findIndex(s => s.id === editingSection.value.id)
  if (index !== -1) {
    currentPage.value.content[index] = editingSection.value
  }
  editingSection.value = null
}

const deleteSection = (index) => {
  currentPage.value.content.splice(index, 1)
}

const duplicateSection = (index) => {
  const section = JSON.parse(JSON.stringify(currentPage.value.content[index]))
  section.id = `section-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`
  currentPage.value.content.splice(index + 1, 0, section)
}

const getSectionIcon = (type) => {
  const element = availableElements.find(el => el.type === type)
  return element ? element.icon : Square
}

const getSectionPreview = (section) => {
  switch (section.type) {
    case 'hero':
      return section.content.title || 'Hero Section'
    case 'content_with_image':
      return section.content.title || 'Content with Image'
    case 'carousel':
      return `${section.content.slides?.length || 0} slides`
    case 'text_block':
      return section.content.title || 'Text Block'
    case 'grid_layout':
      return `${section.content.items?.length || 0} items`
    case 'features':
      return `${section.content.features?.length || 0} features`
    case 'products':
      return `${section.content.product_count || 0} products`
    case 'navigation':
      return `${section.content.menu_items?.length || 0} menu items`
    case 'footer':
      return section.content.title || 'Footer Section'
    case 'slider':
      return `${section.content.slides?.length || 0} slides`
    case 'grid':
      return `${section.content.grid_items?.length || 0} grid items`
    case 'testimonials':
      return `${section.content.testimonials?.length || 0} testimonials`
    case 'cta':
      return section.content.title || 'Call to Action'
    default:
      return 'Section Content'
  }
}

const addSlide = () => {
  if (!editingSection.value.content.slides) {
    editingSection.value.content.slides = []
  }
  editingSection.value.content.slides.push({
    image_url: '',
    alt_text: '',
    title: 'Slide Title',
    subtitle: 'Slide Subtitle',
    description: 'Slide description...',
    button_text: 'Learn More',
    button_url: '#'
  })
}

const removeSlide = (index) => {
  editingSection.value.content.slides.splice(index, 1)
}

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

const addTestimonial = () => {
  if (!editingSection.value.content.testimonials) {
    editingSection.value.content.testimonials = []
  }
  editingSection.value.content.testimonials.push({
    name: 'Customer Name',
    position: 'Position',
    content: 'Testimonial content...',
    rating: 5,
    image_url: ''
  })
}

const removeTestimonial = (index) => {
  editingSection.value.content.testimonials.splice(index, 1)
}

const addMenuItem = () => {
  if (!editingSection.value.content.menu_items) {
    editingSection.value.content.menu_items = []
  }
  editingSection.value.content.menu_items.push({
    label: 'Menu Item',
    url: '#'
  })
}

const removeMenuItem = (index) => {
  editingSection.value.content.menu_items.splice(index, 1)
}

const addSocialLink = () => {
  if (!editingSection.value.content.social_links) {
    editingSection.value.content.social_links = []
  }
  editingSection.value.content.social_links.push({
    platform: 'Social Platform',
    url: 'https://social-platform.com'
  })
}

const removeSocialLink = (index) => {
  editingSection.value.content.social_links.splice(index, 1)
}

const savePage = async () => {
  try {
    // Update slug based on page type
    if (selectedPageType.value === 'home') {
      currentPage.value.slug = 'home'
      currentPage.value.title = 'Home'
    }
    
    if (isEditing.value) {
      // Updating existing page
      await pageStore.updatePage(route.params.id, currentPage.value)
      alert('Page updated successfully!')
    } else {
      // Creating new page
      await pageStore.createPage(currentPage.value)
      alert('Page created successfully!')
    }
    // Redirect to pages list
    router.push('/pages')
  } catch (error) {
    console.error('Error saving page:', error)
    alert('Error saving page: ' + error.message)
  }
}

const previewPage = () => {
  // Preview the page
  if (currentPage.value.slug === 'home') {
    // For home page, open the root URL
    window.open('/', '_blank')
  } else {
    // For other pages, open the page URL
    window.open(`/pages/${currentPage.value.slug}`, '_blank')
  }
}
</script>