<div class="sort-wrapper">
  <div class="sort">
    <select class="select" v-model="sort">
      <option value="" disabled>Sort by</option>
      <option :value="sortType.value" v-for="(sortType, index) in sortTypes" :key="index">
        {{ sortType.name }}
      </option>
    </select>
  </div>
</div>
