<script setup>
import CallTable from '@/components/CallTable.vue'
</script>

<template>
  <div class="min-h-screen bg-gray-100 p-6">
    <!-- Header -->
    <div class="mb-6">
      <h1 class="text-3xl font-semibold text-gray-800">VoIP Call Analytics</h1>
      <p class="text-sm text-gray-500 mt-1">Inbound & Outbound Call Overview</p>
    </div>

    <!-- Call Table -->
    <div class="bg-white shadow-lg rounded-2xl p-6">
      <CallTable />
    </div>
  </div>
</template>
