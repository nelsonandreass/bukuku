<script type="text/javascript">
   var ctx = document.getElementById("myChart");
   var month = <?php echo json_encode($tanggal);?>;
   var report = <?php echo json_encode($report);?>;
   var myChart = new Chart(ctx, {
      type: 'bar',
         data: {
            labels: month,
            datasets: [
               { label: <?php echo json_encode($label);?>,
               data: report,
               
               backgroundColor : <?php echo json_encode($color)?>,
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