<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Document</title>
  </head>
  <body>
    <div style="text-align: center; margin-bottom: 100px">
      <h1>Invoice #<?php echo time(); ?></h1>
    </div>
    <div style="text-align: center; margin-bottom: 30px">
      <table  style="border: 1px solid black;border-collapse: collapse;">
        <thead>
          <tr>
            <th>
              #
            </th>
            <th>
              From
            </th>
            <th>
              To
            </th>
            <th>
              Departure Date
            </th>
            <th>
              Return Date
            </th>
            <th>
              Additional services
            </th>
            <th>
              Journey Type
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              1.
            </td>
            <td>
              <?= $data['from'] ?>
            </td>
            <td>
              <?= $data['to'] ?>
            </td>
            <td>
              <?= $data['departure_date'] ?>
            </td>
            <td>
              <?= ! empty($data['return_date']) ? $data['return_date'] : '-' ?>
            </td>
            <td>
              <?= implode(", ", $data['additional_service']) ?>
            </td>
            <td>
              <?= $data['journey_type'] ?>
            </td>
          </tr>
        </tbody>        
      </table>
    </div>
    <div style="text-align: center; margin-bottom: 100px">
      <table style="border: 1px solid black;border-collapse: collapse;">
        <thead>
          <tr>
            <th>
              Carrier Logo
            </th>
            <th>
              Carrier Name
            </th>
            <th>
              Departure
            </th>
            <th>
              Duration
            </th>
            <th>
              Arrival
            </th>
            <th>
              Price
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <img src="<?= $data['flight']['carrier']['ImageUrl']; ?>" alt="image" />              
            </td>
            <td>
              <?= $data['flight']['carrier']['Name']; ?>
            </td>
            <td>
               <?= $data['flight']['departure']; ?>
            </td>
            <td>
              <?= $data['flight']['duration']; ?>
            </td>
            <td>
              <?= $data['flight']['arrival']; ?>
            </td>
            <td>
              <?= $data['flight']['price']; ?>
            </td>
          </tr>
        </tbody>        
      </table>
    </div>
    <div  style="text-align: right">
      <ul style="list-style: none; font-weight: bold;">
        <li>
          Total price: <?= $data['final_price'] ?>
        </li>
      </ul>
    </div>
  </body>
</html>

<style>
  table { 
    
    width: 100%;
    border: 4px double black;
    border-collapse: collapse;
   }
   th { 
    text-align: left;
    background: #ccc;
    padding: 5px;
    border: 1px solid black;
   }
   td { 
    padding: 5px;
    border: 1px solid black;
   }
</style>