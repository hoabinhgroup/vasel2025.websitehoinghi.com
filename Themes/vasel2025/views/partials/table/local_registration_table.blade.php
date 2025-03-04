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
				<p align="center"><span lang="EN-US">VND 4.000.000</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">VND 3.000.000</span></p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox" 
					name="conference_checklist_item"
					data-attach="apscvir_member"
					value="{{ conferenceFees()['yes'][1]['amount_vn'] }}"
					data-id="{{ conferenceFees()['yes'][1]['id'] }}">
			</td>
		</tr>
		<tr>
			<td width="46%" style="padding: 15px;">
				<p><span lang="EN-US">Physician (non member)</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">VND 5.000.000</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">VND 4.000.000</span></p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox" 
					name="conference_checklist_item"
					value="{{ conferenceFees()['yes'][2]['amount_vn'] }}"
					data-id="{{ conferenceFees()['yes'][2]['id'] }}">
			</td>
		</tr>
		<tr>
			<td width="46%" style="padding: 15px;">
				<p><span lang="EN-US">Allied health (Radiographer, Nurses, Physicist. Scientist, Exhibitors)
						</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">VND 2.000.000</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">VND 1.000.000</span></p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox" 
					name="conference_checklist_item"
					value="{{ conferenceFees()['yes'][3]['amount_vn'] }}"
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
				<p align="center"><span lang="EN-US">VND 1.000.000</span></p>
			</td>
			<td width="23%" style="padding: 15px;">
				<p align="center"><span lang="EN-US">
						<o:p> </o:p>
					</span></p>
			</td>
			<td class="fee_item" width="6%" style="padding: 15px;">
				<input 
					type="checkbox" 
					name="conference_checklist_item"
					data-attach="young_ir"
					value="{{ conferenceFees()['yes'][4]['amount_vn'] }}"
					data-id="{{ conferenceFees()['yes'][4]['id'] }}">
			</td>
		</tr>
	</tbody>
	</table>
	