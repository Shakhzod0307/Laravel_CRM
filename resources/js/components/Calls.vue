<template>

   <div class="p-4 b antialiased font-sans bg-gray-200">
      <!-- component -->
      <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight">Calls

            </h2>
            <span v-if="ratingVisible"
                  :class="[
                                'font-semibold leading-tight border rounded-full py-1 px-2',
                                ratingUpdate ? 'border-green-400 text-green-500' : '',
                                isFading ? 'opacity-0 transition-opacity duration-2000' : 'opacity-100'
                              ]">
                            {{ ratingUpdate }}
                        </span>
          </div>
          <div class="my-2 flex sm:flex-row flex-col">
            <div class="flex flex-row mb-1 sm:mb-0 gap-1">
              <div class="relative">
                <select
                  v-model="selectNumber"
                  class="appearance-none  h-full rounded-l border block appearance-none  bg-white border-gray-400 text-gray-700 py-2 px-8 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                  <option :value="10">10</option>
                  <option :value="50">50</option>
                  <option :value="100">100</option>
                </select>
              </div>
              <div class="relative">
                <select v-model="selectYear"
                        class="appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r focus:bg-white focus:border-gray-500">
                  <option :value="0">Year</option>
                  <option :value="2024">2024</option>
                  <option :value="2023">2023</option>
                  <option :value="2022">2022</option>
                  <option :value="2021">2021</option>
                  <option :value="2020">2020</option>
                  <option :value="2019">2019</option>
                  <option :value="2018">2018</option>
                  <option :value="2017">2017</option>
                  <option :value="2016">2016</option>
                  <option :value="2015">2015</option>
                  <option :value="2014">2014</option>
                  <option :value="2013">2013</option>
                  <option :value="2012">2012</option>
                  <option :value="2011">2011</option>
                  <option :value="2010">2010</option>
                </select>

              </div>
              <div class="relative">
                <select
                  v-model="selectMonth"
                  class="appearance-none  h-full rounded-l border block appearance-none bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                  <option :value="0" >Month</option>
                  <option :value="1">January</option>
                  <option :value="2">February</option>
                  <option :value="3">March</option>
                  <option :value="4">April</option>
                  <option :value="5">May</option>
                  <option :value="6">June</option>
                  <option :value="7">July</option>
                  <option :value="8">August</option>
                  <option :value="8">August</option>
                  <option :value="9">September</option>
                  <option :value="10">October</option>
                  <option :value="11">November</option>
                  <option :value="12">December</option>
                </select>

              </div>

              <div class="relative">
                <div class="custom-dropdown">
                  <button class="dropdown-toggle" @click="toggleDropdown">
                    {{ selectedDay ? selectedDay : 'Day' }}
                  </button>
                  <div v-if="isDropdownOpen" class="dropdown-options">
                    <div class="options-grid">
                      <div
                        v-for="day in days"
                        :key="day"
                        class="option"
                        @click="selectDay(day)"
                      >
                        {{ day }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

<!--              <vue-tailwind-datepicker-->
<!--                v-model="dateStart"-->
<!--                placeholder="Select Dates"-->
<!--                separator=" to "-->
<!--                :shortcuts="false"-->
<!--              />-->
            </div>
          </div>
          <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
              <table class="min-w-full leading-normal">
                <thead>
                <tr>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    ID
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Agent
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    User
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Title
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Status
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Type
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Duration
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Started_at
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Ended at
                  </th>
                  <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    Rating
                  </th>
                </tr>
                </thead>
                <tbody >
                <tr v-for="(call, index) in Calls"
                    :key="call.id">
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{index+1}}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ call.agent.username }}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{call.user.username}}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{call.title}}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                                        <span
                                          :class="{
                                                'relative inline-block px-3 py-1 font-semibold leading-tight': true,
                                                'text-blue-900 bg-blue-200': call.status === 'pending',
                                                'text-yellow-900 bg-yellow-200': call.status === 'in_progress',
                                                'text-green-900 bg-green-200': call.status === 'completed',
                                                'text-red-900 bg-red-200': call.status === 'cancelled'
                                            }">
                                            <span aria-hidden class="absolute inset-0 opacity-50 rounded-full"></span>
                                            <span class="relative">{{ call.status }}</span>
                                        </span>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{call.type}}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{call.duration}} min</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{call.started_at}}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{call.ended_at}}</p>
                  </td>
                  <td class="px-5 py-5 bg-white text-lg">
                    <div class="flex items-center">
                                            <span
                                              v-for="star in [1, 2, 3, 4, 5]"
                                              :key="star"
                                              class="cursor-pointer"
                                              :class="{ 'text-yellow-500': star <= call.rating.rating, 'text-gray-400': star > call.rating.rating }"
                                              @click="updateRating(call, star)"
                                            >
                                                ★
                                            </span>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>

</template>

<script setup>
import {onMounted, ref, watch} from "vue";
import axios from "axios";
import VueTailwindDatepicker from "vue-tailwind-datepicker";
const Calls = ref();
const ratingUpdate = ref(null);
const ratingVisible = ref(false);
const isFading = ref(false);
const selectNumber = ref(10);
const selectYear = ref(0);
const selectMonth = ref(0);// 1-12
const selectedDay = ref(0);
const isDropdownOpen = ref(false);
const days = [0 ,1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]

const dateStart = ref({
  StartDate:'',
  EndDate:'',
});
const formatter = ref({
  date: 'DD',
  month: 'MMM',
  year: 'YYY',
});


function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value;
}
function selectDay(day) {
  selectedDay.value = day;
  isDropdownOpen.value = false;
}
const GetAllCalls = async () => {
  try {
    const calls = await axios.get(`/calls/${selectNumber.value}/${selectYear.value}/${selectMonth.value}/${selectedDay.value}`);
    Calls.value = calls.data.result;
    // console.log(selectYear.value, calls.data.result);
  } catch (error) {
    console.error("Failed to fetch messages:", error);
  }
};
const GetAllCallsByDates = async () => {
  const formatDate = (datetime) => {
    return datetime.split(' ')[0]
  }
  try {
    if (!dateStart.value) {
      console.error("Please select both start and end dates.");
      return;
    }
    const formattedStartDate = formatDate(dateStart.value.StartDate)
    const formattedEndDate = formatDate(dateStart.value.EndDate)
    const calls = await axios.get(`/callsByDate`, {
      params: {
        selectNumber: selectNumber.value,
        dateStart:formattedStartDate,
        dateEnd:formattedEndDate,
      },
    });
    Calls.value = calls.data.result;
    // console.log(selectNumber.value, formattedStartDate,formattedEndDate);

  } catch (error) {
    console.error("Failed to fetch messages:", error);
  }
};

const updateRating = async (call, newRating) => {
  const oldRating = call.rating.rating;
  call.rating.rating = newRating;

  try {
    const response = await axios.post(`/calls/${call.id}/rating`, { rating: newRating });
    if (response.status ===200){
      ratingUpdate.value = response.data.result;
      ratingVisible.value = true;
      isFading.value = false;
      setTimeout(()=>{
        isFading.value = true;
        setTimeout(()=>{
          ratingVisible.value = false;
        },4000)
      },2000)
    }
    // console.log(`${response.data.result} Call ID ${call.id}: ${newRating}`);
  } catch (error) {
    console.error('Error updating rating:', error);
    call.rating.rating = oldRating;
  }
};

onMounted(()=>{
  GetAllCalls();
  setInterval(GetAllCalls, 30000);
  // GetAllCallsByDates();
})
watch(
  [selectNumber, selectYear,selectMonth,selectedDay,dateStart],
  ([newSelectNumber, newSelectYear,newSelectMonth,newSelectedDay,newDateStart]) => {
    if (newSelectNumber || newSelectYear || newSelectMonth || newSelectedDay) {
      GetAllCalls(newSelectNumber, newSelectYear,newSelectMonth,newSelectedDay);
    }else {
      GetAllCallsByDates(newSelectNumber,newDateStart);
    }
  }
);
</script>
<style scoped>
.custom-dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-toggle {
  background-color: white;
  border: 1px solid #ccc;
  padding:8px 15px;
  cursor: pointer;
  width: 100%;
  text-align: left;
}

.dropdown-options {
  position: absolute;
  background-color: white;
  border: 1px solid #ccc;
  z-index: 1;
  width: 300px;
  max-height: 200px;
  overflow-y: auto;
}

.options-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 5px;
  padding: 10px;
}

.option {
  padding: 10px;
  border: 1px solid #ccc;
  cursor: pointer;
  text-align: center;
}

.option:hover {
  background-color: #f0f0f0;
}

</style>
