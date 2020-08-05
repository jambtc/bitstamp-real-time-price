<?php
 /**
  * Bitstamp Real Time Price
  *
  * This library is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  * Lesser General Public License for more details.
  *
  * @package    Bitstamp Real Time Price
  * @author 	Sergio Casizzone
  */
class BitstampRTP {

	public static function RTP(){
		BitstampRTP::euro_real_time_price();

		$output = "<span id=\"real_time_price\" >";
		$output .= "	<div id='rtp_container'>";
		$output .= "		<span id='rtp_price'>...</span> €";
		$output .= "	</div>";
	  $output .= "</span>";

	  return $output;
	}

	public static function euro_real_time_price(){
		echo "<!-- start - euro_real_time_price by Sergio Casizzone -->";
		echo "<script src='https://code.jquery.com/jquery-1.12.4.js'></script>";
		echo "<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>";
	  echo "<script type=\"text/javascript\">\n";

		echo "var ws = new WebSocket('wss://ws.bitstamp.net');"; // New websocket v. 2 for Bitstamp
		echo "var subscription = {
    			'event': 'bts:subscribe',
    			'data': {
					'channel': 'live_trades_btceur'
				}
		};"; // Create object for channel subscription

  	echo "ws.onopen = function () {
			ws.send(JSON.stringify(subscription));
		};"; // send subscription

		echo "ws.onmessage = function (evt) {
			response = JSON.parse(evt.data);
			switch (response.event) {
				case 'trade': {
					$('#rtp_price').html(response.data.price);
					// Run the effect
					var options = {'color':'green'};
      				$( '#rtp_price' ).effect( 'highlight', options, 500, callback );
					console.log('[Bitstamp WebSocket]:',response.data.price);
					break;
				}
				case 'bts:request_reconnect': {
					ws = new WebSocket('wss://ws.bitstamp.net');
					break;
				}
			}
		};"; // manage response

		echo "// Callback function to bring a hidden box back
    			function callback() {
      				setTimeout(function() {
        				$( '#rtp_price' ).removeAttr( 'style' ).hide().fadeIn();
      				}, 1000 );
    };";

		echo "</script>\n";
	  echo "<!-- end - euro_real_time_price by Sergio Casizzone -->\n";
	}
}
?>
