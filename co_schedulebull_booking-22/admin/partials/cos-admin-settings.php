<?php 
$currency = array('usd'=>'USD','aed'=>'AED','afn'=>'AFN','all'=>'ALL','amd'=>'AMD','ang'=>'ANG','aoa'=>'AOA','ars'=>'ARS','aud'=>'AUD','awg'=>'AWG','azn'=>'AZN','bam'=>'BAM','bbd'=>'BBD','bdt'=>'BDT','bgn'=>'BGN','bif'=>'BIF','bmd'=>'BMD','bnd'=>'BND','bob'=>'BOB','brl'=>'BRL','bsd'=>'BSD','bwp'=>'BWP','byn'=>'BYN','bzd'=>'BZD','cad'=>'CAD','cdf'=>'CDF','chf'=>'CHF','clp'=>'CLP','cny'=>'CNY','cop'=>'COP','crc'=>'CRC','cve'=>'CVE','czk'=>'CZK','djf'=>'DJF','dkk'=>'DKK','dop'=>'DOP','dzd'=>'DZD','egp'=>'EGP','etb'=>'ETB','eur'=>'EUR','fjd'=>'FJD','fkp'=>'FKP','gbp'=>'GBP','gel'=>'GEL','gip'=>'GIP','gmd'=>'GMD','gnf'=>'GNF','gtq'=>'GTQ','gyd'=>'GYD','hkd'=>'HKD','hnl'=>'HNL','hrk'=>'HRK','htg'=>'HTG','huf'=>'HUF','idr'=>'IDR','ils'=>'ILS','inr'=>'INR','isk'=>'ISK','jmd'=>'JMD','jpy'=>'JPY','kes'=>'KES','kgs'=>'KGS','khr'=>'KHR','kmf'=>'KMF','krw'=>'KRW','kyd'=>'KYD','kzt'=>'KZT','lak'=>'LAK','lbp'=>'LBP','lkr'=>'LKR','lrd'=>'LRD','lsl'=>'LSL','mad'=>'MAD','mdl'=>'MDL','mga'=>'MGA','mkd'=>'MKD','mmk'=>'MMK','mnt'=>'MNT','mop'=>'MOP','mro'=>'MRO','mur'=>'MUR','mvr'=>'MVR','mwk'=>'MWK','mxn'=>'MXN','myr'=>'MYR','mzn'=>'MZN','nad'=>'NAD','ngn'=>'NGN','nio'=>'NIO','nok'=>'NOK','npr'=>'NPR','nzd'=>'NZD','pab'=>'PAB','pen'=>'PEN','pgk'=>'PGK','php'=>'PHP','pkr'=>'PKR','pln'=>'PLN','pyg'=>'PYG','qar'=>'QAR','ron'=>'RON','rsd'=>'RSD','rub'=>'RUB','rwf'=>'RWF','sar'=>'SAR','sbd'=>'SBD','scr'=>'SCR','sek'=>'SEK','sgd'=>'SGD','shp'=>'SHP','sll'=>'SLL','sos'=>'SOS','srd'=>'SRD','std'=>'STD','szl'=>'SZL','thb'=>'THB','tjs'=>'TJS','top'=>'TOP','try'=>'TRY','ttd'=>'TTD','twd'=>'TWD','tzs'=>'TZS','uah'=>'UAH','ugx'=>'UGX','uyu'=>'UYU','uzs'=>'UZS','vnd'=>'VND','vuv'=>'VUV','wst'=>'WST','xaf'=>'XAF','xcd'=>'XCD','xof'=>'XOF','xpf'=>'XPF','yer'=>'YER','zar'=>'ZAR','zmw'=>'ZMW');
global $cos_admin_i;
?>
<div class="wrap">
   <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
   <form action="options.php" method="post">
   		<?php settings_fields( 'cos_setting' ); ?>
        <h2 class="title" style="padding: 10px 10px;">Stripe Settings</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
						Publishable key
                    </th>
                    <td>
                        <input type="text" style="width:100%" name="cos_setting_options[stripe][publishable_key]" value="<?php echo $cos_options['stripe']['publishable_key']??''; ?>">
                    </td>
                </tr>
				<tr>
                    <th scope="row">
						Secret key
                    </th>
                    <td>
                        <input type="text" style="width:100%" name="cos_setting_options[stripe][secret_key]" value="<?php echo $cos_options['stripe']['secret_key']??''; ?>">
                    </td>
                </tr>
				<tr>
                    <th scope="row">
						Currency
                    </th>
                    <td>
					<select style="width:100%" name="cos_setting_options[stripe][currency]">
						<?php if( !empty($currency) ){
							foreach( $currency as $code=>$name){ ?>
								<option value="<?php echo $code; ?>" <?php echo ($cos_options['stripe']['currency'] && $cos_options['stripe']['currency'] == $code)?'selected':''; ?>><?php echo $name; ?></option>
							<?php }
						}?>
					</select>
                        
                    </td>
                </tr>
            </tbody>
        </table>
		
		<h2 class="title" style="padding: 10px 10px;">Booking Block Dates Settings</h2>
		<div class="cos-blockDatesSettings-Section">
		<table class="cos-blockDatesSettings">
		<?php 
		$cos_block_dates = (isset($cos_options['block_date_ranges']))?$cos_options['block_date_ranges']:array(); ?>
		
		<?php if(!empty($cos_block_dates)){ ?>
			<?php foreach( $cos_block_dates as $date__){ 
				$cos_blockDateItem = '<tr class="cos-DateRangeItem">';
				
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<label>Route From</label>';
				$cos_blockDateItem .= '<select required data-name="route_from" class="cosRouteFrom">
					<option value="All">All</option>';
					
					if(!empty($locations__)){
						foreach($locations__ as $location__){
							$cos_blockDateItem .= '<option value="'.$location__.'" '.((isset($date__['route_from']) && $location__ == $date__['route_from'])?'selected':'').'>'.$location__.'</option>';
						}
					}
					
				$cos_blockDateItem .= '</select>';
				$cos_blockDateItem .= '</td>';
				
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<label>Route To</label>';
				$cos_blockDateItem .= '<select required data-name="route_to" class="cosRouteTo">
					<option value="All">All</option>';
					
					if(!empty($locations__)){
						foreach($locations__ as $location__){
							$cos_blockDateItem .= '<option value="'.$location__.'" '.((isset($date__['route_to']) && $location__ == $date__['route_to'])?'selected':'').'>'.$location__.'</option>';
						}
					}
					
				$cos_blockDateItem .= '</select>';
				$cos_blockDateItem .= '</td>';
				
	
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<label>Date From</label>';
				$cos_blockDateItem .= '<input required type="text" class="cosDateFrom" data-name="date_from" value="'.$date__['date_from'].'">';
				$cos_blockDateItem .= '</td>';
				
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<label>Start Time</label>';
				$cos_blockDateItem .= '<input type="hidden" class="transfer_time" data-name="start_time" value="'.$date__['start_time'].'">';
				$cos_blockDateItem .= '<div class="cos_t_field">'.$this->cos_time_select_field( 'start_time', $date__['start_time_hours'], $date__['start_time_minutes'] ).'</div>';
				$cos_blockDateItem .= '</td>';
				
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<label>Date To</label>';
				$cos_blockDateItem .= '<input required type="text" class="cosDateTo" data-name="date_to" value="'.$date__['date_to'].'">';
				$cos_blockDateItem .= '</td>';
				
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<label>End Time</label>';
				$cos_blockDateItem .= '<input type="hidden" class="transfer_time" data-name="end_time" value="'.$date__['end_time'].'">';
				$cos_blockDateItem .= '<div class="cos_t_field">'.$this->cos_time_select_field( 'end_time', $date__['end_time_hours'], $date__['end_time_minutes'] ).'</div>';
				$cos_blockDateItem .= '</td>';
				
				$cos_blockDateItem .= '<td>';
				$cos_blockDateItem .= '<button type="button" class="cos-remove-item"><span class="dashicons dashicons-remove"></span></button>';
				$cos_blockDateItem .= '</td>';
				
				$cos_blockDateItem .= '</tr>';
				echo $cos_blockDateItem;
			} ?>
		<?php } ?>
			
		</table>
		<button type="button" id="cos-AddDateRangeBtn">Add New Date Range</button>
		</div>
		
		
		<h2 class="title" style="padding: 10px 10px;">Booking Dates Rates Increase/Decrease Settings</h2>
		<div class="cos-rateDatesSettings-Section">
		<table class="cos-rateDatesSettings">
		<?php 
		$cos_rate_dates = (isset($cos_options['rate_date_ranges']))?$cos_options['rate_date_ranges']:array(); ?>
		
		<?php if(!empty($cos_rate_dates)){ ?>
			<?php foreach( $cos_rate_dates as $date__){ 
				$cos_rateDateItem = '<tr class="cos-RateDateRangeItem">';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Route From</label>';
				$cos_rateDateItem .= '<select required data-name="route_from" class="cosRouteFrom">
					<option value="All">All</option>';
					
					if(!empty($locations__)){
						foreach($locations__ as $location__){
							$cos_rateDateItem .= '<option value="'.$location__.'" '.((isset($date__['route_from']) && $location__ == $date__['route_from'])?'selected':'').'>'.$location__.'</option>';
						}
					}
					
				$cos_rateDateItem .= '</select>';
				$cos_rateDateItem .= '</td>';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Route To</label>';
				$cos_rateDateItem .= '<select required data-name="route_to" class="cosRouteTo">
					<option value="All">All</option>';
					
					if(!empty($locations__)){
						foreach($locations__ as $location__){
							$cos_rateDateItem .= '<option value="'.$location__.'" '.((isset($date__['route_to']) && $location__ == $date__['route_to'])?'selected':'').'>'.$location__.'</option>';
						}
					}
					
				$cos_rateDateItem .= '</select>';
				$cos_rateDateItem .= '</td>';
	
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Date From</label>';
				$cos_rateDateItem .= '<input type="text" class="cosDateFrom" data-name="date_from" value="'.$date__['date_from'].'">';
				$cos_rateDateItem .= '</td>';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Start Time</label>';
				$cos_rateDateItem .= '<input type="hidden" class="transfer_time" data-name="start_time" value="'.$date__['start_time'].'">';
				$cos_rateDateItem .= '<div class="cos_t_field">'.$this->cos_time_select_field( 'start_time', $date__['start_time_hours'], $date__['start_time_minutes'] ).'</div>';
				$cos_rateDateItem .= '</td>';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Date To</label>';
				$cos_rateDateItem .= '<input type="text" class="cosDateTo" data-name="date_to" value="'.$date__['date_to'].'">';
				$cos_rateDateItem .= '</td>';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>End Time</label>';
				$cos_rateDateItem .= '<input type="hidden" class="transfer_time" data-name="end_time" value="'.$date__['end_time'].'">';
				$cos_rateDateItem .= '<div class="cos_t_field">'.$this->cos_time_select_field( 'end_time', $date__['end_time_hours'], $date__['end_time_minutes'] ).'</div>';
				$cos_rateDateItem .= '</td>';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Amount (%)</label>';
				$cos_rateDateItem .= '<input required type="number" min="0" step=".01" class="cos_date_amount" data-name="date_amount" value="'.($date__['date_amount']??0).'">';
				$cos_rateDateItem .= '</td>';
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<label>Increase/Decrease</label>';
				$cos_rateDateItem .= '<select required class="cos_amount_type" data-name="amount_type">
										<option '.(($date__['amount_type'] == 'Increase')?'selected':'').' value="Increase">Increase</option>
										<option '.(($date__['amount_type'] == 'Decrease')?'selected':'').' value="Decrease">Decrease</option>
									</select>';
				$cos_rateDateItem .= '</td>';
				
				
				$cos_rateDateItem .= '<td>';
				$cos_rateDateItem .= '<button type="button" class="cos-remove-rate-item"><span class="dashicons dashicons-remove"></span></button>';
				$cos_rateDateItem .= '</td>';
				
				
				$cos_rateDateItem .= '</tr>';
				echo $cos_rateDateItem;
			} ?>
		<?php } ?>
			
		</table>
		<button type="button" id="cos-AddRateDateRangeBtn">Add New Rate</button>
		</div>
		
        <?php submit_button( 'Save Settings' ); ?>
    </form>
</div>