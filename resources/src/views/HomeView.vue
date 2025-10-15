<script setup>
import Carousel from '../components/Carousel.vue'
import ProductView from '@/components/partial/ProductView.vue'
import SolutionsView from '@/components/partial/SolutionsView.vue'
import ProjectView from '@/components/partial/ProjectView.vue'
import AboutUs from '@/components/partial/AboutUs.vue'
import FirmwareModification from '@/components/partial/Firmware Modification.vue'
</script>

<template>
  <main>
    <Carousel />
    <ProductView />
    <FirmwareModification/>
    <SolutionsView />
    <AboutUs />
    <ProjectView />
  </main>
</template>

<script>
// Set the layout to guest to use the new public theme
export default {
  name: 'HomeView',
  metaInfo() {
    return {
      title: 'Home - Moimstone Dasan Indonesia',
      meta: [
        {
          name: 'description',
          content: 'Provide your network connectivity solutions. Trusted distributor and experienced technical support for DASAN equipment in Indonesia. Offers something that is beyond your reach.'
        }
      ]
    }
  }
}
</script>
