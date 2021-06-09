<script type="text/javascript">
   var ctx = document.getElementById("myChart");
   var month = <?php echo json_encode($tanggal);?>;
   var reportincome = <?php echo json_encode($reportincome);?>;
   var reportoutcome = <?php echo json_encode($reportoutcome);?>;
   var reportprofit = <?php echo json_encode($reportprofit);?>;
   console.log(month);
   var data = {
      labels: month,
      datasets: [
         {
            label: 'Pengeluaran',
            data: reportoutcome,
            borderColor: 'rgba(228,61,64, 1)',
            backgroundColor: 'rgba(228,61,64, 0.5)',
         },
         {
            label: 'Pemasukan',
            data: reportincome,
            borderColor: 'rgba(89,152,26, 1)',
            backgroundColor: 'rgba(89,152,26, 0.5)',
         }
         {
            label: 'Keuntungan',
            data: reportprofit,
            borderColor:  'rgba(18,69,98, 1)',
            backgroundColor:  'rgba(18,69,98, 0.5)',
         }
      ]
   };

  
   var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
            labels: month,
            datasets: [
               { 
                  label: <?php echo "pengeluaran";?>,
                  data: reportoutcome,
                  backgroundColor : 'rgba(18,69,98, 0.5)',
               }
            ]
   },
   options: {
      scales: {
         yAxes: [{
            ticks: {
               beginAtZero:true
            }
         }]
      }
   }
});

</script>
