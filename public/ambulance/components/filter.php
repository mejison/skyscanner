<?php
    $link = "Book cheap flights with Commercial airlines for your medical travel";
    require '../../../config/server.php';
  ?>

<div class="filter">
  <div class="from">
    <input list="airport" placeholder="From" v-model="filter.from" />
  </div>
  <div class="to">
    <input list="airport" placeholder="To" v-model="filter.to" />
  </div>
  <div class="departure">
    <input placeholder="Departure" type="date"  min="<?php $rtoday = date("Y-m-d"); echo $rtoday;?>" v-model="filter.departure" />
  </div>
  <div class="arrival">
    <input placeholder="Arrival" type="date" min="<?php $today = date("Y-m-d"); echo $today;?>" v-model="filter.arrival" />
  </div>
  <div class="passangers">
    <input placeholder="Passangers" v-model="filter.passengers" />
  </div>
  <div class="class">
    <select v-model="filter.class">
      <option value="Economy">Economy</option>
      <option value="Business">Business</option>
      <option value="First Class">First Class</option>
    </select>
  </div>
  <div>
    <a href="#" class="search-btn" v-on:click.prevent="onSearchResults">
      <i class="mdi mdi-magnify"></i>
    </a>
  </div>
</div>

<datalist id="airport">
    <?php
        $sql = $db->prepare("SELECT  * FROM airports");
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . mb_convert_encoding($row['code'], "UTF-8", "iso-8859-1") . ', ' . mb_convert_encoding($row['country'], "UTF-8", "iso-8859-1") . '">' . mb_convert_encoding($row['code'], "UTF-8", "iso-8859-1") . ', ' . mb_convert_encoding($row['airport'], "UTF-8", "iso-8859-1") . '</option>';
            }
        } else {
            echo '<option value="none">No airports results found!</option>';
        }
        $db->close();

    ?>
</datalist>