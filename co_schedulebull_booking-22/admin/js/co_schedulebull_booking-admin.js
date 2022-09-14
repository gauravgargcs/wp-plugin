(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 
	let cos_blockDateItem = '';
	
	cos_blockDateItem += '<tr class="cos-DateRangeItem">';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<label>Route From</label>';
	cos_blockDateItem += '<select required data-name="route_from" class="cosRouteFrom"><option value="All">All</option><option value="Alpe d huez">Alpe d huez</option><option value="Avoriaz">Avoriaz</option><option value="Belle Plagne">Belle Plagne</option><option value="Bourg St-Maurice">Bourg St-Maurice</option><option value="Brides Les Bains">Brides Les Bains</option><option value="Chambery airport">Chambery airport</option><option value="Chamonix">Chamonix</option><option value="Champagny en Vanoise">Champagny en Vanoise</option><option value="Chatel">Chatel</option><option value="Courchevel">Courchevel</option><option value="Courchevel Le Praz">Courchevel Le Praz</option><option value="Flaine">Flaine</option><option value="Geneva airport">Geneva airport</option><option value="Grenoble airport">Grenoble airport</option><option value="La Clusaz">La Clusaz</option><option value="La Plagne">La Plagne</option><option value="La Rosiere">La Rosiere</option><option value="La Tania">La Tania</option><option value="Les Arcs">Les Arcs</option><option value="Les Arcs Peisey Nancroix">Les Arcs Peisey Nancroix</option><option value="Les Arcs Peisey Vallandry">Les Arcs Peisey Vallandry</option><option value="Les Coches">Les Coches</option><option value="Les Deux Alpes">Les Deux Alpes</option><option value="Les Gets">Les Gets</option><option value="Les Houches">Les Houches</option><option value="Les Menuires">Les Menuires</option><option value="Les Saisies">Les Saisies</option><option value="Lyon airport">Lyon airport</option><option value="Megeve">Megeve</option><option value="Meribel">Meribel</option><option value="Meribel-Mottaret">Meribel-Mottaret</option><option value="Montalbert">Montalbert</option><option value="Montchavin">Montchavin</option><option value="Morillon">Morillon</option><option value="Morzine">Morzine</option><option value="Pralognon en Vanoise">Pralognon en Vanoise</option><option value="Reberty">Reberty</option><option value="Sainte Foy">Sainte Foy</option><option value="Samoens">Samoens</option><option value="Tignes">Tignes</option><option value="Val Cenis">Val Cenis</option><option value="Val Thorens">Val Thorens</option><option value="Val d Isere">Val d Isere</option><option value="Valmorel">Valmorel</option></select>';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<label>Route To</label>';
	cos_blockDateItem += '<select required data-name="route_to" class="cosRouteTo"><option value="All">All</option><option value="Alpe d huez">Alpe d huez</option><option value="Avoriaz">Avoriaz</option><option value="Belle Plagne">Belle Plagne</option><option value="Bourg St-Maurice">Bourg St-Maurice</option><option value="Brides Les Bains">Brides Les Bains</option><option value="Chambery airport">Chambery airport</option><option value="Chamonix">Chamonix</option><option value="Champagny en Vanoise">Champagny en Vanoise</option><option value="Chatel">Chatel</option><option value="Courchevel">Courchevel</option><option value="Courchevel Le Praz">Courchevel Le Praz</option><option value="Flaine">Flaine</option><option value="Geneva airport">Geneva airport</option><option value="Grenoble airport">Grenoble airport</option><option value="La Clusaz">La Clusaz</option><option value="La Plagne">La Plagne</option><option value="La Rosiere">La Rosiere</option><option value="La Tania">La Tania</option><option value="Les Arcs">Les Arcs</option><option value="Les Arcs Peisey Nancroix">Les Arcs Peisey Nancroix</option><option value="Les Arcs Peisey Vallandry">Les Arcs Peisey Vallandry</option><option value="Les Coches">Les Coches</option><option value="Les Deux Alpes">Les Deux Alpes</option><option value="Les Gets">Les Gets</option><option value="Les Houches">Les Houches</option><option value="Les Menuires">Les Menuires</option><option value="Les Saisies">Les Saisies</option><option value="Lyon airport">Lyon airport</option><option value="Megeve">Megeve</option><option value="Meribel">Meribel</option><option value="Meribel-Mottaret">Meribel-Mottaret</option><option value="Montalbert">Montalbert</option><option value="Montchavin">Montchavin</option><option value="Morillon">Morillon</option><option value="Morzine">Morzine</option><option value="Pralognon en Vanoise">Pralognon en Vanoise</option><option value="Reberty">Reberty</option><option value="Sainte Foy">Sainte Foy</option><option value="Samoens">Samoens</option><option value="Tignes">Tignes</option><option value="Val Cenis">Val Cenis</option><option value="Val Thorens">Val Thorens</option><option value="Val d Isere">Val d Isere</option><option value="Valmorel">Valmorel</option></select>';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<label>Date From</label>';
	cos_blockDateItem += '<input required type="text" class="cosDateFrom" data-name="date_from">';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<label>Start Time</label>';
	cos_blockDateItem += '<input type="hidden" class="transfer_time" data-name="start_time" value="00:00">';
	cos_blockDateItem += '<div class="cos_t_field">'+cos_time_select_field('start_time')+'</div>';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<label>Date To</label>';
	cos_blockDateItem += '<input required type="text" class="cosDateTo" data-name="date_to">';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<label>End Time</label>';
	cos_blockDateItem += '<input type="hidden" class="transfer_time" data-name="end_time" value="00:00">';
	cos_blockDateItem += '<div class="cos_t_field">'+cos_time_select_field('end_time')+'</div>';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '<td>';
	cos_blockDateItem += '<button type="button" class="cos-remove-item"><span class="dashicons dashicons-remove"></span></button>';
	cos_blockDateItem += '</td>';
	
	cos_blockDateItem += '</tr>';
	
	
	
	let cos_rateDateItem = '';
	
	cos_rateDateItem += '<tr class="cos-RateDateRangeItem">';
	
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Route From</label>';
	cos_rateDateItem += '<select required data-name="route_from" class="cosRouteFrom"><option value="All">All</option><option value="Alpe d huez">Alpe d huez</option><option value="Avoriaz">Avoriaz</option><option value="Belle Plagne">Belle Plagne</option><option value="Bourg St-Maurice">Bourg St-Maurice</option><option value="Brides Les Bains">Brides Les Bains</option><option value="Chambery airport">Chambery airport</option><option value="Chamonix">Chamonix</option><option value="Champagny en Vanoise">Champagny en Vanoise</option><option value="Chatel">Chatel</option><option value="Courchevel">Courchevel</option><option value="Courchevel Le Praz">Courchevel Le Praz</option><option value="Flaine">Flaine</option><option value="Geneva airport">Geneva airport</option><option value="Grenoble airport">Grenoble airport</option><option value="La Clusaz">La Clusaz</option><option value="La Plagne">La Plagne</option><option value="La Rosiere">La Rosiere</option><option value="La Tania">La Tania</option><option value="Les Arcs">Les Arcs</option><option value="Les Arcs Peisey Nancroix">Les Arcs Peisey Nancroix</option><option value="Les Arcs Peisey Vallandry">Les Arcs Peisey Vallandry</option><option value="Les Coches">Les Coches</option><option value="Les Deux Alpes">Les Deux Alpes</option><option value="Les Gets">Les Gets</option><option value="Les Houches">Les Houches</option><option value="Les Menuires">Les Menuires</option><option value="Les Saisies">Les Saisies</option><option value="Lyon airport">Lyon airport</option><option value="Megeve">Megeve</option><option value="Meribel">Meribel</option><option value="Meribel-Mottaret">Meribel-Mottaret</option><option value="Montalbert">Montalbert</option><option value="Montchavin">Montchavin</option><option value="Morillon">Morillon</option><option value="Morzine">Morzine</option><option value="Pralognon en Vanoise">Pralognon en Vanoise</option><option value="Reberty">Reberty</option><option value="Sainte Foy">Sainte Foy</option><option value="Samoens">Samoens</option><option value="Tignes">Tignes</option><option value="Val Cenis">Val Cenis</option><option value="Val Thorens">Val Thorens</option><option value="Val d Isere">Val d Isere</option><option value="Valmorel">Valmorel</option></select>';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Route To</label>';
	cos_rateDateItem += '<select required data-name="route_to" class="cosRouteTo"><option value="All">All</option><option value="Alpe d huez">Alpe d huez</option><option value="Avoriaz">Avoriaz</option><option value="Belle Plagne">Belle Plagne</option><option value="Bourg St-Maurice">Bourg St-Maurice</option><option value="Brides Les Bains">Brides Les Bains</option><option value="Chambery airport">Chambery airport</option><option value="Chamonix">Chamonix</option><option value="Champagny en Vanoise">Champagny en Vanoise</option><option value="Chatel">Chatel</option><option value="Courchevel">Courchevel</option><option value="Courchevel Le Praz">Courchevel Le Praz</option><option value="Flaine">Flaine</option><option value="Geneva airport">Geneva airport</option><option value="Grenoble airport">Grenoble airport</option><option value="La Clusaz">La Clusaz</option><option value="La Plagne">La Plagne</option><option value="La Rosiere">La Rosiere</option><option value="La Tania">La Tania</option><option value="Les Arcs">Les Arcs</option><option value="Les Arcs Peisey Nancroix">Les Arcs Peisey Nancroix</option><option value="Les Arcs Peisey Vallandry">Les Arcs Peisey Vallandry</option><option value="Les Coches">Les Coches</option><option value="Les Deux Alpes">Les Deux Alpes</option><option value="Les Gets">Les Gets</option><option value="Les Houches">Les Houches</option><option value="Les Menuires">Les Menuires</option><option value="Les Saisies">Les Saisies</option><option value="Lyon airport">Lyon airport</option><option value="Megeve">Megeve</option><option value="Meribel">Meribel</option><option value="Meribel-Mottaret">Meribel-Mottaret</option><option value="Montalbert">Montalbert</option><option value="Montchavin">Montchavin</option><option value="Morillon">Morillon</option><option value="Morzine">Morzine</option><option value="Pralognon en Vanoise">Pralognon en Vanoise</option><option value="Reberty">Reberty</option><option value="Sainte Foy">Sainte Foy</option><option value="Samoens">Samoens</option><option value="Tignes">Tignes</option><option value="Val Cenis">Val Cenis</option><option value="Val Thorens">Val Thorens</option><option value="Val d Isere">Val d Isere</option><option value="Valmorel">Valmorel</option></select>';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Date From</label>';
	cos_rateDateItem += '<input type="text" class="cosDateFrom" data-name="date_from">';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Start Time</label>';
	cos_rateDateItem += '<input type="hidden" class="transfer_time" data-name="start_time" value="00:00">';
	cos_rateDateItem += '<div class="cos_t_field">'+cos_time_select_field('start_time')+'</div>';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Date To</label>';
	cos_rateDateItem += '<input type="text" class="cosDateTo" data-name="date_to">';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>End Time</label>';
	cos_rateDateItem += '<input type="hidden" class="transfer_time" data-name="end_time" value="00:00">';
	cos_rateDateItem += '<div class="cos_t_field">'+cos_time_select_field('end_time')+'</div>';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Amount (%)</label>';
	cos_rateDateItem += '<input required type="number" min="0" step=".01" class="cos_date_amount" data-name="date_amount">';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<label>Increase/Decrease</label>';
	cos_rateDateItem += '<select required class="cos_amount_type" data-name="amount_type"><option value="Increase">Increase</option><option value="Decrease">Decrease</option></select>';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '<td>';
	cos_rateDateItem += '<button type="button" class="cos-remove-rate-item"><span class="dashicons dashicons-remove"></span></button>';
	cos_rateDateItem += '</td>';
	
	cos_rateDateItem += '</tr>';
	
	$(document).ready(function(){
        cos_update_item_input_names( '.cos-blockDatesSettings', '.cos-DateRangeItem', 'block_date_ranges' );
		
		cos_update_item_input_names( '.cos-rateDatesSettings', '.cos-RateDateRangeItem', 'rate_date_ranges' );
    });
	
	$(document).on('click', '#cos-AddDateRangeBtn', function(){
        $('.cos-blockDatesSettings').append(cos_blockDateItem);
		
		$(".cosDateFrom").datepicker();
		$(".cosDateFrom").datepicker().on("change", function() {
			var minDate = new Date(this.value);
			
			$(this).parent().next().next().find('.cosDateTo').datepicker("option", "minDate", minDate );
			$(this).parent().next().next().find('.cosDateTo').datepicker('setDate', minDate );
		});
				
		$(".cosDateTo").datepicker().on("change", function() {
			var minDate = this.value;
		   $(this).parent().prev().prev().find('.cosDateFrom').datepicker("option", "maxDate", minDate);
		});
		
        cos_update_item_input_names( '.cos-blockDatesSettings', '.cos-DateRangeItem', 'block_date_ranges' );
    });
	
	$(document).on('click', '#cos-AddRateDateRangeBtn', function(){
        $('.cos-rateDatesSettings').append(cos_rateDateItem);
		
		$(".cosDateFrom").datepicker();
		$(".cosDateFrom").datepicker().on("change", function() {
			var minDate = new Date(this.value);
			
			$(this).parent().next().next().find('.cosDateTo').datepicker("option", "minDate", minDate );
			$(this).parent().next().next().find('.cosDateTo').datepicker('setDate', minDate );
		});
				
		$(".cosDateTo").datepicker().on("change", function() {
			var minDate = this.value;
		   $(this).parent().prev().prev().find('.cosDateFrom').datepicker("option", "maxDate", minDate);
		});
		
        cos_update_item_input_names( '.cos-rateDatesSettings', '.cos-RateDateRangeItem', 'rate_date_ranges' );
    });
	
	$(document).on('click','.cos-remove-item', function(){
        $(this).parent().parent().remove();
        cos_update_item_input_names( '.cos-blockDatesSettings', '.cos-DateRangeItem', 'block_date_ranges' );
    });
	
	$(document).on('click','.cos-remove-rate-item', function(){
        $(this).parent().parent().remove();
        cos_update_item_input_names( '.cos-rateDatesSettings', '.cos-RateDateRangeItem', 'rate_date_ranges' );
    });
	
	$(document).ready(function(){
		$(".cosDateFrom").datepicker();
		$(".cosDateFrom").datepicker().on("change", function() {
			var minDate = new Date(this.value);
			
			$(this).parent().next().next().find('.cosDateTo').datepicker("option", "minDate", minDate );
			$(this).parent().next().next().find('.cosDateTo').datepicker('setDate', minDate );
		});
				
		$(".cosDateTo").datepicker().on("change", function() {
			var minDate = this.value;
		   $(this).parent().prev().prev().find('.cosDateFrom').datepicker("option", "maxDate", minDate);
		});
		
		
		$(document).on('change','.cos_time_hours, .cos_time_minutes', function(){
            var time_picker__ = $(this).parent();
            var hours__ = time_picker__.find('.cos_time_hours').val();
            var minutes__ = time_picker__.find('.cos_time_minutes').val();
            time_picker__.prev().val(hours__+':'+minutes__);
        });
	});
	
	function cos_update_item_input_names( table_, row__, setting_key ){

        var cos_itemID = 0;
		var table_ = $(table_);
        table_.find(row__).each( function(){

            $(this).find('input').each(function(){
                var field_name__ = $(this).attr('data-name'); 
                $(this).attr('name', 'cos_setting_options['+setting_key+']['+cos_itemID+']['+field_name__+']');
            });
			
			$(this).find('select').each(function(){
                var field_name__ = $(this).attr('data-name'); 
                $(this).attr('name', 'cos_setting_options['+setting_key+']['+cos_itemID+']['+field_name__+']');
            });

            cos_itemID++;
        });
    }
	
	
	function cos_time_select_field( name_ ){
		var time_select_field = '';
		
		time_select_field += '<select data-name="'+name_+'_hours" class="cos_time_hours">';
		time_select_field +='<option value="00">00</option>';
		time_select_field +='<option value="01">01</option>';
		time_select_field +='<option value="02">02</option>';
		time_select_field +='<option value="03">03</option>';
		time_select_field +='<option value="04">04</option>';
		time_select_field +='<option value="05">05</option>';
		time_select_field +='<option value="06">06</option>';
		time_select_field +='<option value="07">07</option>';
		time_select_field +='<option value="08">08</option>';
		time_select_field +='<option value="09">09</option>';
		time_select_field +='<option value="10">10</option>';
		time_select_field +='<option value="11">11</option>';
		time_select_field +='<option value="12">12</option>';
		time_select_field +='<option value="13">13</option>';
		time_select_field +='<option value="14">14</option>';
		time_select_field +='<option value="15">15</option>';
		time_select_field +='<option value="16">16</option>';
		time_select_field +='<option value="17">17</option>';
		time_select_field +='<option value="18">18</option>';
		time_select_field +='<option value="19">19</option>';
		time_select_field +='<option value="20">20</option>';
		time_select_field +='<option value="21">21</option>';
		time_select_field +='<option value="22">22</option>';
		time_select_field +='<option value="23">23</option>';
		time_select_field += '</select>';
		
		time_select_field += '<div class="cos_time_saperator">:</div>';
		
		time_select_field +='<select data-name="'+name_+'_minutes" class="cos_time_minutes">';
		time_select_field +='<option value="00">00</option>';
		time_select_field +='<option value="05">05</option>';
		time_select_field +='<option value="10">10</option>';
		time_select_field +='<option value="15">15</option>';
		time_select_field +='<option value="20">20</option>';
		time_select_field +='<option value="25">25</option>';
		time_select_field +='<option value="30">30</option>';
		time_select_field +='<option value="35">35</option>';
		time_select_field +='<option value="40">40</option>';
		time_select_field +='<option value="45">45</option>';
		time_select_field +='<option value="50">50</option>';
		time_select_field +='<option value="55">55</option>';
		time_select_field +='</select>';
		
		return time_select_field;
	}

})( jQuery );
