<script type="text/javascript">
    
      function drawPumpPieChart() {
        var total_orders = "<?php echo e($arr_pump_data['total_orders']??0); ?>";
        var tot_delivered_qty = "<?php echo e($arr_pump_data['tot_delivered_qty']??0); ?>";
        var tot_remaing_qty = "<?php echo e($arr_pump_data['tot_remaing_qty']??0); ?>";
        //console.log(total_orders+' '+tot_delivered_qty+' '+tot_remaing_qty);
        var data = google.visualization.arrayToDataTable([
          ['Pump', 'No Of Pumps'],
          ['Total Ordered',parseInt(total_orders)],
          ['Delivered',parseInt(tot_delivered_qty)],
          ['Remaining',parseInt(tot_remaing_qty)],
 
        ]);

        var options = {
          title: 'Pumps',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('total_pump_pie_chart_id'));
        chart.draw(data, options);
      }

      function drawSalesPieChart() {

        var total_sales       = "<?php echo e($arr_sales_data['total_sales']??0); ?>";
        var invoice_amount    = "<?php echo e($arr_sales_data['invoice_amount']??0); ?>";
        var need_to_collect   = "<?php echo e($arr_sales_data['need_to_collect']??0); ?>";
        //console.log(total_orders+' '+tot_delivered_qty+' '+tot_remaing_qty);
        var data = google.visualization.arrayToDataTable([
          ['Sales', 'Amount'],
          ['Total Sales',parseInt(total_sales)],
          ['Invoice Amount',parseInt(invoice_amount)],
          ['Need To Collect',parseInt(need_to_collect)],
 
        ]);

        var options = {
          title: 'Total Sales',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('total_sales_pie_chart_id'));
        chart.draw(data, options);
      }
      function drawCustRejPumpPieChart() {
      
        var pump_tot_cust_rejected_qty  = "<?php echo e($arr_rej_pump_data['glob_cust_rejected_qty']??0); ?>";
        var pump_tot_int_rejected_qty   = "<?php echo e($arr_rej_pump_data['glob_int_rejected_qty']??0); ?>";
        //console.log(total_orders+' '+tot_delivered_qty+' '+tot_remaing_qty);
        var data = google.visualization.arrayToDataTable([
          ['Pump', 'Quantity'],
          ['Total Rejected Qty',parseInt(pump_tot_cust_rejected_qty)],
          ['Internel Rejected Qty',parseInt(pump_tot_int_rejected_qty)],
        ]);

        var options = {
          title: 'Rejected Pumps',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('cust_rej_pie_chart_id'));
        chart.draw(data, options);
      }
      function drawPumpBarChart()
      {
           var arr_pump_data = [];
           pump_chart_str    = $('#pump_chart_str').val();
           if(pump_chart_str!="")
           {
               var arr_pump_data = JSON.parse(pump_chart_str);
              var data = google.visualization.arrayToDataTable(arr_pump_data);
              var options = {
                chart: {
                  title: 'Pump Data',
                }
              };

              var chart = new google.charts.Bar(document.getElementById('pump_bar_chart_id'));

              chart.draw(data, google.charts.Bar.convertOptions(options));
           }
         
      }
      function drawRejPumpBarChart()
      {
           var arr_rej_pump_data     = [];
           rej_pump_chart_str    = $('#rej_pump_chart_str').val();
           if(rej_pump_chart_str!="")
           {
               arr_rej_pump_data = JSON.parse(rej_pump_chart_str);
               console.log(arr_rej_pump_data);
              var data          = google.visualization.arrayToDataTable(arr_rej_pump_data);
              var options = {
                chart: {
                  title: 'Rej Pump Data',
                }
              };

              var chart = new google.charts.Bar(document.getElementById('rej_pump_bar_chart_id'));
              chart.draw(data, google.charts.Bar.convertOptions(options));
           }
         
      }
      function drawStatementChart()
      {
            var arr_booking_data  = [];
            booking_statement_str   = $('#booking_statement_str').val();
            if(booking_statement_str!="")
            {
               arr_booking_data = JSON.parse(booking_statement_str);
               var data = google.visualization.arrayToDataTable(arr_booking_data);
           

              var options = {
                title: 'Booking Statement',
                curveType: 'function',
                legend: { position: 'bottom' }
              };

              var chart = new google.visualization.LineChart(document.getElementById('statement_chart_id'));

              chart.draw(data, options);

            }
         
      }
</script><?php /**PATH /home/cintvase/readymix.seeen.sa/resources/views/dashboard/chart.blade.php ENDPATH**/ ?>