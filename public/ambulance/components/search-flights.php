  <?php
    $link = "Book cheap flights with Commercial airlines for your medical travel";
    require '../../../config/server.php';
  ?>

  <div class="warpper">
    <div id="title"><h1>Search and Book Cheap Flights for your Medical Travel</h1></div>
    <input class="radio" id="one" name="group" type="radio" checked>
    <input class="radio" id="two" name="group" type="radio">
    <div class="tabs">
        <label class="tab" id="one-tab" for="one" v-on:click="onClickTab('return')">Return</label>
        <label class="tab" id="two-tab" for="two" v-on:click="onClickTab('oneway')">One Way</label>
    </div>
    <div class="panels">
        <div class="panel" id="one-panel">
            <div class="return_body">
                <form name="return" id="return" class="return" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                            <label>
                                <input name="deprture" ref="return.from" list="airport" type="text" placeholder="From..." required v-on:change="onChange('from', $event)" />
                            </label>
                            <label>
                                <input name="destinat" ref="return.to" list="airport" type="text" placeholder="To..." required v-on:change="onChange('to', $event)" />
                            </label>
                            <label>
                                <input name="deprtdte" ref="return.departure_date" type="date" placeholder="Departure Date" min="<?php $rtoday = date("Y-m-d"); echo $rtoday;?>" required v-on:change="onChange('departure_date', $event)" />
                        </label>
                            <label>
                                <input name="destndte" ref="return.return_date" type="date" placeholder="Return Date" min="<?php $today = date("Y-m-d"); echo $today;?>" required v-on:change="onChange('return_date', $event)" />
                        </label>
                            <label>
                                <input name="flcls" ref="return.class" type="text" placeholder="Flight Class" list="class" required v-on:change="onChange('class', $event)" />
                            </label>
                            <label>
                                <input name="passnum" ref="return.passengers" type="number" min="0" max="10" placeholder="Number of passengers" required v-on:change="onChange('passengers', $event)" />
                            </label>
                            <datalist id="airport">
                                <?php
                                    $sql = $db->prepare("SELECT  * FROM airports");
                                    $sql->execute();
                                    $result = $sql->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option data-country="' . mb_convert_encoding($row['country'], "UTF-8", "iso-8859-1") . '" value="' . mb_convert_encoding($row['location'], "UTF-8", "iso-8859-1") . ', ' . mb_convert_encoding($row['country'], "UTF-8", "iso-8859-1") . '" data-location="' . mb_convert_encoding($row['location'], "UTF-8", "iso-8859-1") . ', ' . mb_convert_encoding($row['country'], "UTF-8", "iso-8859-1") . '" data-code="' . mb_convert_encoding($row['code'], "UTF-8", "iso-8859-1") . '">' . mb_convert_encoding($row['code'], "UTF-8", "iso-8859-1") . ', ' . mb_convert_encoding($row['airport'], "UTF-8", "iso-8859-1") . '</option>';
                                        }
                                    } else {
                                        echo '<option value="none">No airports results found!</option>';
                                    }
                                    $db->close();                                    
                                ?>
                            </datalist>
                            <datalist id="class">
                                <option value="Economy">Economy</option>
                                <option value="Business">Business</option>
                                <option value="First Class">First Class</option>
                            </datalist>
                        <button name="search" type="button" v-on:click.prevent="onSearch()">Search</button>
                </form>
            </div>
        </div>
        <div class="panel" id="two-panel">
            <div class="oneway_body">
                <form name="oneway" id="oneway" class="oneway" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
                    <label>
                        <input name="deprture" ref="oneway.from" list="airport" type="text" placeholder="From..."  required v-on:change="onChange('from', $event)" required />
                    </label>

                    <label>
                        <input name="destinat" ref="oneway.to" list="airport" type="text" placeholder="To..."  required v-on:change="onChange('to', $event)" />
                    </label>

                    <label>
                        <input name="deprtdte" ref="oneway.departure_date" type="date" placeholder="Departure Date"  min="<?php $today = date("Y-m-d"); echo $today;?>" required v-on:change="onChange('departure_date', $event)" />
                    </label>

                    <label>
                        <input name="flcls" ref="oneway.class" type="text" placeholder="Flight Class" list="class" v-on:change="onChange('class', $event)" required />
                    </label>

                    <label>
                        <input name="passnum" ref="oneway.passengers" type="number" min="0" max="10" placeholder="Number of passengers" v-on:change="onChange('passengers', $event)" required />
                    </label>

                    <button  type="button" v-on:click.prevent="onSearch()">Search</button>
                </form>
            </div>
        </div>
    </div>
  </div>