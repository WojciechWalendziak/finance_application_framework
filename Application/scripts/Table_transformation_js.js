
	//google.charts.load('current', {packages: ['corechart']});
	function expand_table(table_to_expand, amount)
	{
		let table_to_expand_rows = table_to_expand.rows;
		let cell_to_check = table_to_expand_rows[table_to_expand_rows.length - 1].getElementsByTagName("td")[0];
		let cell_to_check_text = cell_to_check.textContent || cell_to_check.innerText;
		if(cell_to_check_text != "TOTAL AMOUNT")
		{
			table_expanded = table_to_expand.insertRow(-1);
			table_expanded.className = 'row';
			let cell_one = table_expanded.insertCell(0);
			let cell_two = table_expanded.insertCell(1);
			cell_one.innerHTML = "TOTAL AMOUNT";
			cell_one.className = 'class="col-sm-3';
			cell_one.style.display = "flex";
			cell_two.innerHTML = amount;
			cell_two.className = 'class="col-sm-3';
			cell_two.style.display = "flex";
		}
		else
		{
			let cell_to_update = table_to_expand_rows[table_to_expand_rows.length - 1].getElementsByTagName("td")[1];
			cell_to_update.innerHTML = amount;
			cell_to_update.style.display = "flex";
		}
	}

	var today = new Date();
	
	let current_date = {

		current_year: today.getFullYear(),
		current_month: today.getMonth() + 1,
		current_day: today.getDate(),
		return_year : function() {
			return this.current_year;
		  },
		return_month : function() {
			return this.current_month;
		  },
		return_day : function() {
			return this.current_day;
		  }
	};

	function get_table(requested_table)
	{
		let my_table = document.getElementById(requested_table);
		return my_table;
	}

	function get_selected_field()
	{
		let selected_value = document.getElementById("period");
		selected_value = selected_value.value;
		return selected_value;
	}

	function close_modal()
	{
		let modal = document.getElementById("myModal");
		modal.style.display = "none";
	}

	function transform_table()
	{
		let income_table = get_table("income_table");
		let expense_table = get_table("expense_table");
		let current_year = current_date.return_year();
		let current_month = current_date.return_month();
		let current_day = current_date.return_day();
		let period = get_selected_field();
		let period_string = String(period);
		if(period_string != "niestandardowy")
		{
			let sum_income = filter_by_standard_timeframes(income_table, period, current_year, current_month, current_day);
			let list_for_chart = filter_by_standard_timeframes_bis(income_table, period, current_year, current_month, current_day);
			drawChart(list_for_chart, "income_chart");
			expand_table(income_table, sum_income);
			let sum_expense = filter_by_standard_timeframes(expense_table, period, current_year, current_month, current_day);
			list_for_chart = filter_by_standard_timeframes_bis(expense_table, period, current_year, current_month, current_day);
			drawChart(list_for_chart, "expense_chart");
			expand_table(expense_table, sum_expense);
		}
		else
		{
			let modal = document.getElementById("myModal");
			modal.style.display = "flex";
			sum = 0;
		}
	}
	function filter_by_own_timeframe(e)
	{
		e.preventDefault() // to stop submit
		let income_table = get_table("income_table");
		let expense_table = get_table("expense_table");
		let sum_income = summarize_by_own_timeframe(income_table);
		let list_for_chart = create_tabel_to_chart(income_table);
		drawChart(list_for_chart, "income_chart");
		let sum_expense = summarize_by_own_timeframe(expense_table);
		list_for_chart = create_tabel_to_chart(expense_table);
		drawChart(list_for_chart, "expense_chart");
		expand_table(income_table, sum_income);
		expand_table(expense_table, sum_expense);
		close_modal();
	}
	function drawChart(chart_row_list, chart_id)
	{
		let data1 = google.visualization.arrayToDataTable(chart_row_list);
		let options1 = {'title': 'piechart','width': 800, 'height':600, 'margin': 10, legend: {textStyle: {color: 'white'}}, title: {textStyle: {color: 'white'}}, 'backgroundColor': '#303030'};
		let chart = new google.visualization.PieChart(document.getElementById(chart_id));
		chart.draw(data1, options1);
	}
	function summarize_by_own_timeframe(requested_table)
	{
		//let modal_box = document.getElementById("myModal");
		let start_date = document.getElementById("start_date").value;
		let end_date = document.getElementById("end_date").value;
		let [start_year, start_month, start_day] = start_date.split('-');
		let [end_year, end_month, end_day] = end_date.split('-');
		//modal_box.style.display = "none";
		let requested_table_rows = requested_table.rows;
		let category = "";
		let sum = 0;
		let filtered_amount = 0;
		for (let i = 1; i < requested_table_rows.length - 1; i++)
		{
			let bill_date = requested_table_rows[i].getElementsByTagName("td")[2];
			let txtValue = bill_date.textContent || bill_date.innerText;
			let [year_to_check, month_to_check, day_to_check] = txtValue.split('-');
			let bill_amount = requested_table_rows[i].getElementsByTagName("td")[1];
			let amountValue = bill_amount.textContent || bill_date.innerText;
			let amount = Number(amountValue);
			category = requested_table_rows[i].getElementsByTagName("td")[0];
			filtered_amount = filter_table(start_year, start_month, start_day, end_year, end_month, end_day, year_to_check, month_to_check, day_to_check, requested_table_rows[i], amount);
			sum = sum + filtered_amount;
		}
		return sum;
	}
	function create_tabel_to_chart(requested_table)
	{
		//let modal_box = document.getElementById("myModal");
		let start_date = document.getElementById("start_date").value;
		let end_date = document.getElementById("end_date").value;
		let [start_year, start_month, start_day] = start_date.split('-');
		let [end_year, end_month, end_day] = end_date.split('-');
		//modal_box.style.display = "none";
		let requested_table_rows = requested_table.rows;
		let category = "";
		let chart_row = ["", ""];
		let chart_row_list = [chart_row];
		let filtered_amount = 0;
		let check = 0;
		for (let i = 1; i < requested_table_rows.length - 1; i++)
		{
			let cell_to_check = requested_table_rows[i].getElementsByTagName("td")[0];
			let cell_to_check_text = cell_to_check.textContent || cell_to_check.innerText;
			if(cell_to_check_text != "TOTAL AMOUNT")
			{
				let bill_date = requested_table_rows[i].getElementsByTagName("td")[2];
				let txtValue = bill_date.textContent || bill_date.innerText;
				let [year_to_check, month_to_check, day_to_check] = txtValue.split('-');
				let bill_amount = requested_table_rows[i].getElementsByTagName("td")[1];
				let amountValue = bill_amount.textContent || bill_date.innerText;
				let amount = Number(amountValue);
				category = requested_table_rows[i].getElementsByTagName("td")[0];
				category = category.innerHTML;
				filtered_amount = filter_table_bis(start_year, start_month, start_day, end_year, end_month, end_day, year_to_check, month_to_check, day_to_check, amount);
				if(filtered_amount > 0)
				{
					if(chart_row_list.length > 0)
					{
						for(x = 0; x < chart_row_list.length; x++)
						{
							if(chart_row_list[x][0] == category)
							{
								check = 1;
								chart_row_list[x][1] = chart_row_list[x][1] + amount;
								x = chart_row_list.length;
							}
						}
						if(check == 0)
						{
							chart_row = [category, amount];
							chart_row_list.push(chart_row);
						}
						check = 0;
					}
					else
					{
						chart_row = [category, amount];
						chart_row_list.push(chart_row);
					}
				}
			}
		}
		return chart_row_list;
	}
	function filter_by_standard_timeframes(requested_table, period, current_year, current_month, current_day)
	{
		let sum = 0;
        let filtered_amount = 0;
		let requested_table_rows = requested_table.rows;
		for (let i = 1; i < requested_table_rows.length - 1; i++)
		{
			let cell_to_check = requested_table_rows[i].getElementsByTagName("td")[0];
			let cell_to_check_text = cell_to_check.textContent || cell_to_check.innerText;
			if(cell_to_check_text != "TOTAL AMOUNT")
			{
				let bill_date = requested_table_rows[i].getElementsByTagName("td")[2];
				let txtValue = bill_date.textContent || bill_date.innerText;
				let [year_to_check, month_to_check, day_to_check] = txtValue.split('-');
				let bill_amount = requested_table_rows[i].getElementsByTagName("td")[1];
				let amountValue = bill_amount.textContent || bill_date.innerText;
				let amount = Number(amountValue);

				switch (period) {
					case "biezacy_miesiac":
						{
                            filtered_amount = filter_table(current_year, current_month, 1, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, requested_table_rows[i], amount);
							sum = sum + filtered_amount;
						};
					break;
					case "poprzedni_miesiac":
						{
							if(current_month > 1)
							{
								filtered_amount = filter_table(current_year, current_month - 1, current_day, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, requested_table_rows[i], amount);
                                sum = sum + filtered_amount;
                            }
							else
							{
								filtered_amount = filter_table(current_year - 1, 12, current_day, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, requested_table_rows[i], amount);
                                sum = sum + filtered_amount;
                            }
						};
					break;
					case "biezacy_rok":
						{
							{
								filtered_amount = filter_table(current_year, 1, 1, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, requested_table_rows[i], amount);
                                sum = sum + filtered_amount;
                            };
						};
					break;
					case "cala_historia":
						{
							{
								sum = sum + amount;
								requested_table_rows[i].style.display = "flex";
							};
						};
					break;
				}
			}
		}
		return sum;
	}
	function filter_by_standard_timeframes_bis(requested_table, period, current_year, current_month, current_day)
	{
		let sum = 0;
        let filtered_amount = 0;
		let requested_table_rows = requested_table.rows;
		let check = 0;
		let chart_row = ["", ""];
		let chart_row_list = [chart_row];

		for (let i = 1; i < requested_table_rows.length - 1; i++)
		{
			let cell_to_check = requested_table_rows[i].getElementsByTagName("td")[0];
			let cell_to_check_text = cell_to_check.textContent || cell_to_check.innerText;
			if(cell_to_check_text != "TOTAL AMOUNT")
			{
				let bill_date = requested_table_rows[i].getElementsByTagName("td")[2];
				let txtValue = bill_date.textContent || bill_date.innerText;
				let [year_to_check, month_to_check, day_to_check] = txtValue.split('-');
				let bill_amount = requested_table_rows[i].getElementsByTagName("td")[1];
				let amountValue = bill_amount.textContent || bill_date.innerText;
				let amount = Number(amountValue);
				let category = "";
				category = requested_table_rows[i].getElementsByTagName("td")[0];
				category = category.innerHTML;

				switch (period) {
					case "biezacy_miesiac":
						{
                            filtered_amount = filter_table_bis(current_year, current_month, 1, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, amount);
							if(filtered_amount > 0)
							{
								if(chart_row_list.length > 0)
								{
									for(x = 0; x < chart_row_list.length; x++)
									{
										if(chart_row_list[x][0] == category)
										{
											check = 1;
											chart_row_list[x][1] = chart_row_list[x][1] + amount;
											x = chart_row_list.length;
										}
									}
									if(check == 0)
									{
										chart_row = [category, amount];
										chart_row_list.push(chart_row);
									}
									check = 0;
								}
								else
								{
									chart_row = [category, amount];
									chart_row_list.push(chart_row);
								}
							}
						};
					break;
					case "poprzedni_miesiac":
						{
							if(current_month > 1)
							{
								filtered_amount = filter_table_bis(current_year, current_month - 1, current_day, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, amount);
                            }
							else
							{
								filtered_amount = filter_table_bis(current_year - 1, 12, current_day, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, amount);
                            }
							if(filtered_amount > 0)
							{
								if(chart_row_list.length > 0)
								{
									for(x = 0; x < chart_row_list.length; x++)
									{
										if(chart_row_list[x][0] == category)
										{
											check = 1;
											chart_row_list[x][1] = chart_row_list[x][1] + amount;
											x = chart_row_list.length;
										}
									}
									if(check == 0)
									{
										chart_row = [category, amount];
										chart_row_list.push(chart_row);
									}
									check = 0;
								}
								else
								{
									chart_row = [category, amount];
									chart_row_list.push(chart_row);
								}
							}
						};
					break;
					case "biezacy_rok":
						{
							{
								filtered_amount = filter_table_bis(current_year, 1, 1, current_year, current_month, current_day, year_to_check, month_to_check, day_to_check, amount);
                                if(filtered_amount > 0)
								{
									if(chart_row_list.length > 0)
									{
										for(x = 0; x < chart_row_list.length; x++)
										{
											if(chart_row_list[x][0] == category)
											{
												check = 1;
												chart_row_list[x][1] = chart_row_list[x][1] + amount;
												x = chart_row_list.length;
											}
										}
										if(check == 0)
										{
											chart_row = [category, amount];
											chart_row_list.push(chart_row);
										}
										check = 0;
									}
									else
									{
										chart_row = [category, amount];
										chart_row_list.push(chart_row);
									}
								}
                            };
						};
					break;
					case "cala_historia":
						{
							if(chart_row_list.length > 0)
							{
								for(x = 0; x < chart_row_list.length; x++)
								{
									if(chart_row_list[x][0] == category)
									{
										check = 1;
										chart_row_list[x][1] = chart_row_list[x][1] + amount;
										x = chart_row_list.length;
									}
								}
								if(check == 0)
								{
									chart_row = [category, amount];
									chart_row_list.push(chart_row);
								}
								check = 0;
							}
							else
							{
								chart_row = [category, amount];
								chart_row_list.push(chart_row);
							}
						};
					break;
				}
			}
		}
		return chart_row_list;
	}
function filter_table(start_year, start_month, start_day, end_year, end_month, end_day, checked_year, checked_month, checked_day, checked_row, amount)
{
	if(start_year == end_year)
	{
		if(start_month == end_month)
		{
			if(checked_year == start_year && checked_month == start_month && checked_day >= start_day && checked_day <= end_day)
			{
				checked_row.style.display = "flex";
				sum = amount;
			}
			else
			{
				checked_row.style.display = "none";
				sum = 0;
			}
		}
		else
		{
			if(checked_year == start_year && checked_month == start_month && checked_day >= start_day)
			{
				checked_row.style.display = "flex";
				sum = amount;
			}
			else if(checked_year == start_year && checked_month == end_month && checked_day <= end_day)
			{
				checked_row.style.display = "flex";
				sum = amount;
			}
			else if(checked_year == start_year && checked_month > start_month && checked_month < end_month)
			{
				checked_row.style.display = "flex";
				sum = amount;
			}
			else
			{
				checked_row.style.display = "none";
				sum = 0;
			}
		}
	}
	else
	{
		if(checked_year == start_year)
		{
			if(checked_month == start_month)
			{
				if(checked_day >= start_day)
				{
					checked_row.style.display = "flex";
					sum = amount;
				}
				else
				{
					checked_row.style.display = "none";
					sum = 0;
				}
			}
			else if(checked_month > start_month)
			{
				checked_row.style.display = "flex";
				sum = amount;
			}
			else
			{
				checked_row.style.display = "none";
				sum = 0;
			}
		}
		else if(checked_year == end_year)
		{
			if(checked_month == end_month)
			{
				if(checked_day <= end_day)
				{
					checked_row.style.display = "flex";
					sum = amount;
				}
				else
				{
					checked_row.style.display = "none";
					sum = 0;
				}
			}
			else if(checked_month < end_month)
			{
				checked_row.style.display = "flex";
				sum = amount;
			}
			else
			{
				checked_row.style.display = "none";
				sum = 0;
			}
		}
		else if(checked_year > start_year && checked_year < end_year)
		{
			checked_row.style.display = "flex";
			sum = amount;
		}
		else
		{
			checked_row.style.display = "none";
			sum = 0;
		}
	}
	return sum;
}
function filter_table_bis(start_year, start_month, start_day, end_year, end_month, end_day, checked_year, checked_month, checked_day, amount)
{
	if(start_year == end_year)
	{
		if(start_month == end_month)
		{
			if(checked_year == start_year && checked_month == start_month && checked_day >= start_day && checked_day <= end_day)
			{
				sum = amount;
			}
			else
			{
				sum = 0;
			}
		}
		else
		{
			if(checked_year == start_year && checked_month == start_month && checked_day >= start_day)
			{
				sum = amount;
			}
			else if(checked_year == start_year && checked_month == end_month && checked_day <= end_day)
			{
				sum = amount;
			}
			else if(checked_year == start_year && checked_month > start_month && checked_month < end_month)
			{
				sum = amount;
			}
			else
			{
				sum = 0;
			}
		}
	}
	else
	{
		if(checked_year == start_year)
		{
			if(checked_month == start_month)
			{
				if(checked_day >= start_day)
				{
					sum = amount;
				}
				else
				{
					sum = 0;
				}
			}
			else if(checked_month > start_month)
			{
				sum = amount;
			}
			else
			{
				sum = 0;
			}
		}
		else if(checked_year == end_year)
		{
			if(checked_month == end_month)
			{
				if(checked_day <= end_day)
				{
					sum = amount;
				}
				else
				{
					sum = 0;
				}
			}
			else if(checked_month < end_month)
			{
				sum = amount;
			}
			else
			{
				sum = 0;
			}
		}
		else if(checked_year > start_year && checked_year < end_year)
		{
			sum = amount;
		}
		else
		{
			sum = 0;
		}
	}
	return sum;
}
