<script setup>
import { ref, computed, watch, onMounted } from 'vue'

const calls = ref([])
const searchQuery = ref('')
const filterType = ref('All')
const filterStatus = ref('All')
const currentPage = ref(1)
const itemsPerPage = 5
const isLoading = ref(true)
const sortKey = ref('')
const sortOrder = ref('asc')

async function fetchCalls() {
  try {
    isLoading.value = true
    const response = await fetch('http://localhost:8000/api/calls')
    const data = await response.json()
    calls.value = data.map(call => ({
      id: call.id,
      type: call.direction === 'inbound' ? 'Inbound' : 'Outbound',
      caller: call.caller,
      duration: call.duration,
      status: capitalize(call.status),
      time: call.timestamp,
      recording: call.recording_url || ''
    }))
  } catch (error) {
    console.error('Error fetching calls:', error)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  fetchCalls()
})

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
}

function durationToSeconds(duration) {
  const [min, sec] = duration.split(':').map(Number)
  return min * 60 + sec
}

const filteredCalls = computed(() => {
  let data = calls.value

  if (filterType.value !== 'All') {
    data = data.filter(call => call.type === filterType.value)
  }

  if (filterStatus.value !== 'All') {
    data = data.filter(call => call.status === filterStatus.value)
  }

  if (searchQuery.value) {
    data = data.filter(call =>
      call.caller.toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  }

  if (sortKey.value) {
    data = [...data].sort((a, b) => {
      let valA = a[sortKey.value]
      let valB = b[sortKey.value]

      if (sortKey.value === 'duration') {
        valA = durationToSeconds(valA)
        valB = durationToSeconds(valB)
      }

      if (sortKey.value === 'time') {
        valA = new Date(valA)
        valB = new Date(valB)
      }

      return sortOrder.value === 'asc' ? valA - valB : valB - valA
    })
  }

  return data
})

const totalPages = computed(() =>
  Math.ceil(filteredCalls.value.length / itemsPerPage)
)

const paginatedCalls = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  return filteredCalls.value.slice(start, start + itemsPerPage)
})

watch([searchQuery, filterType, filterStatus], () => {
  currentPage.value = 1
})

function toggleSort(key) {
  if (sortKey.value === key) {
    sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortKey.value = key
    sortOrder.value = 'asc'
  }
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}

function exportCSV() {
  const rows = [['Type', 'Caller', 'Duration', 'Status', 'Time', 'Recording']]
  filteredCalls.value.forEach(call => {
    rows.push([call.type, call.caller, call.duration, call.status, call.time, call.recording])
  })

  const csvContent = rows.map(e => e.join(',')).join('\n')
  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' })
  const url = URL.createObjectURL(blob)
  const link = document.createElement('a')
  link.setAttribute('href', url)
  link.setAttribute('download', 'voip_calls.csv')
  document.body.appendChild(link)
  link.click()
  document.body.removeChild(link)
}
</script>

<template>
  <div class="space-y-6">

    <!-- Filters Group -->
    <div class="bg-[#f5f7fa] p-4 rounded-lg shadow-sm space-y-4">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="w-full sm:w-1/3">
          <label class="block text-sm text-gray-600 mb-1">Search by Caller</label>
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Enter number..."
            class="px-4 py-2 border rounded-lg w-full"
          />
        </div>
        <div class="w-full sm:w-1/4">
          <label class="block text-sm text-gray-600 mb-1">Call Type</label>
          <select
            v-model="filterType"
            class="px-4 py-2 border rounded-lg w-full"
            :class="{'border-[#14a5ff]': filterType !== 'All'}"
          >
            <option value="All">All Types</option>
            <option value="Inbound">Inbound</option>
            <option value="Outbound">Outbound</option>
          </select>
        </div>
        <div class="w-full sm:w-1/4">
          <label class="block text-sm text-gray-600 mb-1">Call Status</label>
          <select
            v-model="filterStatus"
            class="px-4 py-2 border rounded-lg w-full"
            :class="{'border-[#14a5ff]': filterStatus !== 'All'}"
          >
            <option value="All">All Status</option>
            <option value="Completed">Completed</option>
            <option value="Missed">Missed</option>
            <option value="Declined">Declined</option>
          </select>
        </div>
        <div class="w-full sm:w-auto flex items-end">
          <button
            @click="exportCSV"
            class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
          >
            Export CSV
          </button>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm text-left text-gray-600 border border-gray-200">
        <thead class="bg-gray-200 text-xs uppercase text-gray-700">
          <tr>
            <th class="px-4 py-3">Type</th>
            <th class="px-4 py-3">Caller</th>
            <th class="px-4 py-3 cursor-pointer" @click="toggleSort('duration')">
              Duration <span v-if="sortKey === 'duration'">({{ sortOrder }})</span>
            </th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3 cursor-pointer" @click="toggleSort('time')">
              Time <span v-if="sortKey === 'time'">({{ sortOrder }})</span>
            </th>
            <th class="px-4 py-3">Recording</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="isLoading">
            <td colspan="6" class="text-center px-4 py-6">Loading...</td>
          </tr>
          <tr v-if="!paginatedCalls.length && !isLoading">
            <td colspan="6" class="text-center px-4 py-6 text-gray-500">No results found.</td>
          </tr>
          <tr
            v-for="(call, index) in paginatedCalls"
            :key="call.id"
            :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
            class="border-b transition hover:bg-blue-50"
          >
            <td class="px-4 py-3 font-bold">{{ call.type }}</td>
            <td class="px-4 py-3">{{ call.caller }}</td>
            <td class="px-4 py-3">{{ call.duration }}</td>
            <td class="px-4 py-3 font-bold">{{ call.status }}</td>
            <td class="px-4 py-3">{{ call.time }}</td>
            <td class="px-4 py-3">
              <a
                :href="call.recording"
                target="_blank"
                class="text-blue-600 hover:underline"
              >
                Download
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-4">
      <button
        @click="prevPage"
        :disabled="currentPage === 1"
        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 disabled:opacity-50"
      >
        Previous
      </button>
      <span class="text-gray-600">Page {{ currentPage }} of {{ totalPages }}</span>
      <button
        @click="nextPage"
        :disabled="currentPage === totalPages"
        class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 disabled:opacity-50"
      >
        Next
      </button>
    </div>
  </div>
</template>
