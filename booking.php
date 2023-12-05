<!DOCTYPE html>
 <html>
    <head>
        <title>

        </title>
    </head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
 $(document).ready(function() {
$.datepicker.setDefaults({
dateFormat: 'yy-mm-dd'  
});
$(function() {
da = $("#da").datepicker()
leave = $("#leave").datepicker()
datepic = $("#datepic").datepicker()
dateout = $("#dateout").datepicker()
});
});
  </script>
    <body>
        <h1>Make a booking</h1>
        <h2>
            <a href='return to bookings.php'>[Return to Booking listing]</a>
            <a href="returnto main.php">[Return to main page]</a>
        </h2>
        <h3>Booking for test</h3>
        <form>
            <label for="room">Room(name,type,beds)</label>
            <input type="text">

            <p>  
                <label for="da">Check In Date:</label>
                <input type="text" id="da" name="da" required>
            </p>

            <p>
                <label for="leave">Check Out Date:</label>
                 <input type="text" id="leave" name="leave" required>
            </p>
            <p>
                <label for="">Phone Number</label>
                <input type="tel" placeholder="(64)123 1234">
                </p>
                <p>
                    <label for="booking Extras"> Booking Extras:</label>
                    <textarea id="Booking Extras" name="Booking Extras" rows="5" required></textarea>
                </p>
                <p>
                    <input type="button" value="ADD">
                </p>
                <hr>
                <h2>search for room Availability</h2>

                <label for="datepic">Check In Date:</label>
                <input type="text" id="datepic" name="datepic" required>

                <label for="dateout">Check Out Date:</label>
                <input type="text" id="dateout" name="dateout" required>

                <input type="button" value="search Availability">
                
                <div id="roomavailabel">
                    <table border="1">
                        <tr>
                            <th>Room</th> <th>Room Name</th><th>Room Type</th> <th>Beds</th>
                        </tr>
                        <tr> <td>10</td> <td>studio</td> <td>a</td> <td>5</td> </tr>   <tr>  <td>22</td> <td>studio</td> <td>B</td> <td>5</td></tr> <tr> <td>13</td> <td>top level</td> <td>c</td> <td>3</td>
                        </tr>
                        <tr> <td>13</td> <td>top level</td> <td>D</td> <td>3</td> </tr> <tr><td>14</td> <td>junior</td> <td>D</td> <td>2</td></tr>
                        <tr><td>16</td> <td>top level</td> <td>B</td> <td>3</td></tr><tr> <td>7</td> <td>junior</td> <td>e</td> <td>2</td> </tr>
                    </table>
        
        </form>

    </body>
 </html>