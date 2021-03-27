<script type="text/javascript">
   var ctx = document.getElementById("myChart");
   var month = <?php echo json_encode($tanggal);?>;
   var report = <?php echo json_encode($report);?>;
   console.log(month);
   var myChart = new Chart(ctx, {
      type: 'bar',
         data: {
            labels: month,
            datasets: [
               { label: 'Pemasukan',
               data: report,
               backgroundColor :[
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
                'rgba(255, 129, 102, 1)',
            ],
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