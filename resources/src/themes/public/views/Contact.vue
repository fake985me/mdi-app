<template>
  <div class="py-16 px-4 bg-blue-50">
    <div class="max-w-7xl mx-auto">
      <div class="mb-12 text-center">
        <div class="mb-6">
          <p class="text-base font-semibold uppercase tracking-wide text-blue-600">
            Contact
          </p>
          <h1 class="font-heading mb-4 font-bold tracking-tight text-gray-900 text-3xl sm:text-5xl">
            Get in Touch
          </h1>
        </div>
        <p class="mt-3 mb-12 text-lg text-gray-600 max-w-3xl mx-auto">
          Provide your network connectivity solutions. Trusted distributor and experienced technical
          support for DASAN equipment in Indonesia. Offers something that is beyond your reach.
        </p>
      </div>

      <div class="flex flex-col lg:flex-row items-stretch justify-center gap-12">
        <!-- Contact Information -->
        <div class="w-full lg:w-2/5">
          <div class="bg-white rounded-xl shadow-lg p-8 h-full">
            <p class="mt-3 mb-8 text-lg text-gray-600">
              Have questions about our products or services? Reach out to us and our team will get back to you as soon as possible.
            </p>
            
            <div class="space-y-8">
              <!-- Address -->
              <div class="flex">
                <div class="flex h-12 w-12 items-center justify-center rounded bg-blue-900 text-gray-50 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-6 w-6">
                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                    </path>
                  </svg>
                </div>
                <div class="ml-6">
                  <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">Our Address</h3>
                  <p class="text-gray-600">
                    Gedung Tifa Arum Realty<br>
                    3th Floor Suite 301<br>
                    Kuningan Barat<br> 
                    Jakarta Selatan 12710
                  </p>
                </div>
              </div>

              <!-- Contact -->
              <div class="flex">
                <div class="flex h-12 w-12 items-center justify-center rounded bg-blue-900 text-gray-50 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-6 w-6">
                    <path
                      d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2">
                    </path>
                    <path d="M15 7a2 2 0 0 1 2 2"></path>
                    <path d="M15 3a6 6 0 0 1 6 6"></path>
                  </svg>
                </div>
                <div class="ml-6">
                  <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">Contact</h3>
                  <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Office:</strong></p>
                    <p><a href="tel:+622129306714" class="text-blue-600 text-lg hover:underline">021 2930-6714</a></p>
                    
                    <p class="mt-3"><strong>Email:</strong></p>
                    <p><a href="mailto:support@mdi-solutions.com" class="text-blue-600 hover:underline">support@mdi-solutions.com</a></p>
                    <p><a href="mailto:info@mdi-solutions.com" class="text-blue-600 hover:underline">info@mdi-solutions.com</a></p>
                  </div>
                </div>
              </div>

              <!-- Sales and Marketing -->
              <div class="flex">
                <div class="flex h-12 w-12 items-center justify-center rounded bg-blue-900 text-gray-50 flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-6 w-6">
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                    <path d="M12 7v5l3 3"></path>
                  </svg>
                </div>
                <div class="ml-6">
                  <h3 class="mb-2 text-lg font-medium leading-6 text-gray-900">Sales and Marketing</h3>
                  <div class="space-y-2 text-gray-600">
                    <p>Eko Wibowo : +62 857-1623-9555</p>
                    <p>Hadi : +62 887-0978-7005</p>
                    <p>Karma : +62 877-8900-8833</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact Form -->
        <div class="w-full lg:w-3/5">
          <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
            
            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Name -->
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                <input 
                  id="name" 
                  v-model="form.name" 
                  required 
                  placeholder="Your name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input 
                  id="email" 
                  v-model="form.email" 
                  type="email" 
                  required 
                  placeholder="Your email address"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
              </div>

              <!-- Subject -->
              <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <input 
                  id="subject" 
                  v-model="form.subject" 
                  placeholder="What is this regarding?"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                />
              </div>

              <!-- Message -->
              <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                <textarea 
                  id="message" 
                  v-model="form.message" 
                  required 
                  placeholder="Your message..."
                  rows="6"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                ></textarea>
              </div>

              <!-- Submit Button -->
              <div class="pt-4">
                <button 
                  type="submit" 
                  class="w-full bg-blue-700 text-white p-3 rounded-lg hover:bg-blue-800 transition duration-300 font-medium"
                >
                  Send Message
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const form = ref({
  name: '',
  email: '',
  subject: '',
  message: ''
})

function handleSubmit() {
  const { name, email, subject, message } = form.value
  
  // Create email content
  const emailSubject = subject ? encodeURIComponent(subject) : encodeURIComponent(`Message from ${name}`)
  const emailBody = encodeURIComponent(
    `Name: ${name}\n` +
    `Email: ${email}\n` +
    (subject ? `Subject: ${subject}\n\n` : '\n') +
    `${message}`
  )
  
  const recipient = "info@mdi-solutions.com"
  
  // Try opening Gmail first
  const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${recipient}&su=${emailSubject}&body=${emailBody}`
  const mailtoUrl = `mailto:${recipient}?subject=${emailSubject}&body=${emailBody}`
  
  // Open Gmail in new tab
  const newTab = window.open(gmailUrl, "_blank")
  
  // If blocked, fallback to mailto
  if (!newTab || newTab.closed || typeof newTab.closed === "undefined") {
    window.location.href = mailtoUrl
  } else {
    // Wait 1.5 seconds, if user closes tab too quickly, fallback
    setTimeout(() => {
      if (newTab.closed) {
        window.location.href = mailtoUrl
      }
    }, 1500)
  }
}
</script>

<style scoped>
/* Add any specific styles for the contact page */
</style>