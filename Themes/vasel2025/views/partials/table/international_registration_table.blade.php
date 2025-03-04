<table border="1" cellspacing="0" cellpadding="0" width="100%"
	style="border-collapse: collapse; width: 100%; border-width: 1px; border-spacing: 0px;">
	<tbody>
		<tr>
			<td width="46%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">
						<o:p> </o:p>
					</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">Including</span></p>
				<p align="center"><span lang="EN-US">Gala Dinner</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">Without</span></p>
				<p align="center"><span lang="EN-US">Gala Dinner</span></p>
			</td>
			<td width="6%" valign="top" style="padding: 15px;">
				<p align="center"><span lang="EN-US">
						<o:p> </o:p>
					</span></p>
			</td>
		</tr>
		<tr>
			<td width="46%" style="padding: 15px;">
				<p><span lang="EN-US">Physician (APSCVIR member)</span><span lang="EN-US"> *</span><span lang="EN-US">
						
					</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="include_gala_1" data-galadinner="yes" class="include_item_gala">US$ 450</p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="without_gala_1" data-galadinner="no" class="without_item_gala">US$ 350</p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox"  
					name="conference_checklist_item"
					value="{{ conferenceFees()['yes'][1]['amount'] }}"
                    data-attach="apscvir_member"
					data-id="{{ conferenceFees()['yes'][1]['id'] }}">
			</td>
		</tr>
        <!-- <tr>
            <td colspan="4">
                <div class="attach_section form-group">
                <div class="row no-gutters">
                <label for=""><strong>(If you are a Physician (APSCVIR member), please provide your student card in the form of an image or PDF file.</strong><sup>*</sup>:</label>
                </div>	
                <div class="row no-gutters">
                     <input type="file" class="form-control col-md-12" id="attachment" name="attachment" value="">		
            
                </div>
                </div>
            </td>
        </tr> -->
		<tr>
			<td width="46%" style="padding: 15px;">
				<p><span lang="EN-US">Physician (non member)</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="include_gala_2" data-galadinner="yes" class="include_item_gala">US$ 550</p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="without_gala_2" data-galadinner="no" class="without_item_gala">US$ 450</p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox"
					name="conference_checklist_item"
					value="{{ conferenceFees()['yes'][2]['amount'] }}"
					data-id="{{ conferenceFees()['yes'][2]['id'] }}">
			</td>
		</tr>
		<tr>
			<td width="46%" style="padding: 15px;">
				<p><span lang="EN-US">Allied health (Radiographer, Nurses, Physicist. Scientist, Exhibitors)
						</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="include_gala_3" data-galadinner="yes" class="include_item_gala">US$ 250</p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="without_gala_3" data-galadinner="no" class="without_item_gala">US$ 150</p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox" 
					name="conference_checklist_item"
					value="{{ conferenceFees()['yes'][3]['amount'] }}"
					data-id="{{ conferenceFees()['yes'][3]['id'] }}">
			</td>
		</tr>
		<tr>
			<td width="46%" style="padding: 15px;">
				<p><span lang="EN-US">Young IR trainee*&lt;35 years old (Medical Student, Resident, Fellow)</span><span
						lang="EN-US"> *</span><span lang="EN-US">
						
					</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="include_gala_4" data-galadinner="yes" class="include_item_gala">US$ 150</p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center" id="without_gala_4" data-galadinner="no" class="without_item_gala"></p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox"
					name="conference_checklist_item"            
					value="{{ conferenceFees()['yes'][4]['amount'] }}"
                    data-attach="young_ir"
					data-id="{{ conferenceFees()['yes'][4]['id'] }}">
			</td>
		</tr>
	</tbody>
	</table>
	