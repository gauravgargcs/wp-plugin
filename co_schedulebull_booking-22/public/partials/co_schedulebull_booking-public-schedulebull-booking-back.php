<div class="cosBookingForm-main transfer-window">
    <div class="cosBooking-loader-box" style="display:none;">
       <div class="loader-filter"></div> 
    </div>
    <?php echo $msg; ?>
    <div class="inner-window">
        <form method="post" id="cosBookingForm">
            <?php
            wp_nonce_field( 'cos_booking_action', 'cos_booking_action_field' ); ?>
            
            <div class="cosBookingStep1 cosStep1Handel">
                <div class="part-1">
            
                    <div class="transfer-from">
    
                        <select name="place_from" data-text="Transfer From" id="cos_place_from" required>
                            <option value="">Transfer From:</option>
                            
                            <?php if(!empty($locations__)){ ?>
                                <?php foreach($locations__ as $location__){ ?>
                                    <option value="<?php echo $location__; ?>"><?php echo $location__; ?></option>
                                <?php } ?>
                            <?php } ?>
                            
                        </select>
                    </div>
                    
                    <div class="date-time date-time-one">
                        <input type="date" name="date_one" data-text="Date" class="transfer_date _one" required>
                        <input type="hidden" name="time_one" data-text="Time" class="transfer_time _one" required>
                        <div class="cos_time_picker">
                            <select class="cos_time_hours">
                                <option value="00">00</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                            </select>
                            <div class="cos_time_saperator">:</div>
                            <select class="cos_time_minutes">
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="transfer-to">
                        <select name="place_to" data-text="Transfer To" id="cos_place_to" required>
                            <option value="">Transfer To:</option>
                            
                        </select>
                    </div>
                    
                    <div class="date-time date-time-one">
                        <input type="date" name="date_one_to" data-text="Date" class="transfer_date _one_to" required>
                        <input type="hidden" name="time_one_to" data-text="Time" class="transfer_time _one_to" required>
                        <div class="cos_time_picker">
                            <select class="cos_time_hours">
                                <option value="00">00</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                            </select>
                            <div class="cos_time_saperator">:</div>
                            <select class="cos_time_minutes">
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                            </select>
                        </div>
                    </div>
    
                    
                    <div class="date-time date-time-round" style="display:none;">
                        <label>From</label>
                        <input type="date" name="date_round" data-text="Date" class="transfer_date _round">
                        <input type="hidden" name="time_round" data-text="Time" class="transfer_time _round">

                        <div class="cos_time_picker">
                            <select class="cos_time_hours">
                                <option value="00">00</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                            </select>
                            <div class="cos_time_saperator">:</div>
                            <select class="cos_time_minutes">
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                            </select>
                        </div>
                    </div>
                    
    
                    <div class="date-time date-time-round" style="display:none;">
                        <label>To</label>
                        <input type="date" name="date_round_to" data-text="Date" class="transfer_date _round_to">
                        <input type="hidden" name="time_round_to" data-text="Time" class="transfer_time _round_to">

                        <div class="cos_time_picker">
                            <select class="cos_time_hours">
                                <option value="00">00</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                            </select>
                            <div class="cos_time_saperator">:</div>
                            <select class="cos_time_minutes">
                                <option value="00">00</option>
                                <option value="05">05</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="30">30</option>
                                <option value="35">35</option>
                                <option value="40">40</option>
                                <option value="45">45</option>
                                <option value="50">50</option>
                                <option value="55">55</option>
                            </select>
                        </div>
                    </div>
    
                </div>
    
                <div class="part-2">
                    <div class="transfer-type">   
                        <div class="myradio">
                            <input type="radio" name="cosb_trip_type" id="one" value="One Way" class="myradio__input" checked>
                            <label for="one" class="myradio__label">One way</label>
                        </div>
                        <div class="myradio">
                            <input type="radio" name="cosb_trip_type" id="two" value="Round trip" class="myradio__input">
                            <label for="two" class="myradio__label">Round trip</label>
                        </div>
                    </div>
                </div>
    
                <div class="part-3">
    
                    <select name="adults_" id="cos_adults_" data-text="Adults" required>
                        <option value="">Adults</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="20">21</option>
                        <option value="20">22</option>
                        <option value="20">23</option>
                        <option value="20">24</option>
                    </select>
    
                    <select name="childrens_" id="cos_childrens_" data-text="Children">
                        <option value="">Children</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    
                </div>
            </div>
            
            <div class="cosBookingStep2 cosStep2Handel" style="display:none;">
                
                <div class="transfer-details cos-step2-sec">
                    <b class="setep-title">Transfer: <a href="javascript:void(0)" class="cosEditStep2">Edit</a></b>
                    <span>Please check if the information is correct in this section.</span>
                    <div class="transfer-inner">
                       <div class="t-detail-line">
                           <span>Origin:</span><span id="valFrom"></span>
                       </div>
                       
                        <div class="t-detail-line">
                           <span>Destination:</span><span id="valTo"></span>
                       </div>
                       
                        <div class="t-detail-line">
                           <span>Arrival date & time:</span><span id="valArrDatetime"></span>
                       </div>
                       
                        <div class="t-detail-line">
                           <span>Passengers:</span><span id="valPassengers"></span>
                       </div>
                       
                        <div class="t-detail-line">
                           <span>Price Total:</span><span id="valprice_total"></span>
                       </div>
                       
                     
                    </div>
                </div>
                
                <div class="step-e_inner cos-step2-sec">
                    
                    <b>Lead passangers details:</b>
                    <div class="schedule_field">
                    <input type="text" name="cos_name" data-text="Name" placeholder="Name:*" required>
                    
                    </div>
                    
                    <div class="schedule_field">
                    <input type="text" name="cos_surname" data-text="Surname" placeholder="Surname:*" required>
                    </div>
                    
                    <div class="schedule_field">
                    <input type="mail" name="cos_email" data-text="Email" placeholder="Email:*" required>
                    </div>
                    
                    <div class="schedule_field">
                    <input type="text" name="cos_mobile" data-text="Mobile phone" placeholder="Mobile phone11111:*" required>
                    <span class="field-msg">Please specify country code as well.</span>
                    </div>
                    
                    <div class="schedule_field">
                    <input type="text" name="cos_mobile_second" placeholder="2nd Mobile phone:">
                    <span class="field-msg">Please specify country code as well.</span>
                    </div>
                    
                    <div class="schedule_field">
                    <input type="text" name="cos_language" placeholder="Luggage info:">
                    </div>
                    
                    <div class="schedule_field">
                    <textarea name="cos_additional_notes" placeholder="Additional notes:"></textarea>
                    </div>
                
                </div>

                <div class="step-e_inner cos-step2-sec">
                    
                    <b>Do you required child seats?</b>

                    <div class="schedule_field">
                        <input type="text" name="cos_infant_seats" data-text="Infant seats" placeholder="Infant seats">
                        <span class="field-msg">Babies weight 0-13kg (0-1 years)</span>
                    </div>

                    <div class="schedule_field">
                        <input type="text" name="cos_child_seats" data-text="Child seats" placeholder="Child seats">
                        <span class="field-msg">Childs weight 9-18kg (1-4 years)</span>
                    </div>

                    <div class="schedule_field">
                        <input type="text" name="cos_booster_seats" data-text="Booster seats" placeholder="Booster seats">
                        <span class="field-msg">Childs weight 18-36kg (4+ years)</span>
                    </div>
                
                </div>

                <div class="step-e_inner cos-step2-sec">
                    
                    <b>Are you bringing any oversized luggage?</b>

                    <div class="schedule_field">
                        <input type="text" name="cos_ski_board_bags" data-text="Ski/borad bags" placeholder="Ski/borad bags">
                        <span class="field-msg"></span>
                    </div>
                
                </div>
                
                <div class="cos-flight-details cos-step2-sec">
                <b class="setep-title">Flight and accomodation details:</b>
        
                     <div class="schedule_field">
                    <input type="text" name="cos_Outbound_flight_number" placeholder="Outbound flight number, Date, Time">
                    </div>
                    
                    <div class="schedule_field">
                    <input type="text" name="cos_Return_flight_number" placeholder="Return flight number, Date, Time">
                    </div>
                    
                    <!--<div class="schedule_field">
                    <input type="time" name="cos_Return_flight_time" placeholder="flight time:">
                    </div>-->
                    
                    <div class="schedule_field">
                    <input type="text" name="cos_Hotel_name_address" placeholder="Hotel name & address:">
                    <span class="field-msg">Please specify chalet, hotel or apartment name and address.</span>
                    </div>
                    
                </div>
                
                 <div class="cos-flight-conf cos-step2-sec">
                     <b class="setep-title">Flight and accomodation details:</b>
        
                  
                    
                    <div class="schedule_field">
                    <input type="radio" value="1" name="cos_i_agree" data-text="I agree" required> I agree with Terms & Conditions<sup>*</sup> <a href="https://loyaltransfers.com/terms-and-conditions/">Please read our Terms and Conditions here.</a>
                     </div>
                    
                </div>
                
            </div>
            
            
            <input type="hidden" name="cos_route_price_total" value="0">
            <input type="hidden" name="cos_route_id_one">
            <input type="hidden" name="cos_route_id_round">
        </form>
        </div>

        <div class="order-btn">
            <span class="order-price">Total: <bdi>€0.00</bdi></span><span class="Next-button cosStep1Handel"><a href="javascript:void(0)">Next</a></span><span class="order-button cosStep2Handel" style="display:none;"><a href="javascript:void(0)">ORDER NOW</a></span>
        </div>

    </div>
