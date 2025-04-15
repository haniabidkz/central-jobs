var Post = {
    init: function(){
        Post.List();
    },
    List:function(){
        am4core.ready(function() {
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end
            
            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            
            chart.data = [
              {
                candidate: "Active",
                count: activeCandidate,
                "color": am4core.color("#28a745")
              },
              {
                candidate: "Blocked",
                count: blockedCandidate,
                "color": am4core.color("#eb3528")
              }
            ];
            
            //chart.innerRadius = am4core.percent(40);
            //chart.depth = 120;
            
            chart.legend = new am4charts.Legend();
            
            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "count";
            series.dataFields.depthValue = "count";
            series.dataFields.category = "candidate";
            series.slices.template.cornerRadius = 5;
            series.colors.step = 3;
            series.labels.template.disabled = true;
            series.ticks.template.disabled = true;
            series.drawLabelsEnabled = false;
            series.slices.template.propertyFields.fill = "color";
            
            var chart1 = am4core.create("chartdiv1", am4charts.PieChart3D);
            chart1.hiddenState.properties.opacity = 0; // this creates initial fade-in
            
            chart1.data = [
              {
                company: "Active",
                count: activeCompany,
                color: am4core.color("#28a745")
              },
              {
                company: "Blocked",
                count:blockedCompany,
                color: am4core.color("#eb3528")
              }
            ];
            
            // chart1.innerRadius = am4core.percent(40);
            // chart1.depth = 120;
            
            chart1.legend = new am4charts.Legend();
            
            var series1 = chart1.series.push(new am4charts.PieSeries3D());
            series1.dataFields.value = "count";
            series1.dataFields.depthValue = "count";
            series1.dataFields.category = "company";
            series1.slices.template.cornerRadius = 5;
            series1.colors.step = 3;
            series1.labels.template.disabled = true;
            series1.ticks.template.disabled = true;
            series1.slices.template.propertyFields.fill = "color";
            
            
            var chart2 = am4core.create("chartdiv2", am4charts.PieChart3D);
            chart2.hiddenState.properties.opacity = 0; // this creates initial fade-in
            
            chart2.data = [
              {
                job: "Onging",
                count: ongoingJob,
                color: am4core.color("#28a745")
              },
              {
                job: "Scheduled",
                count: scheduledJob,
                color: am4core.color("#ffc107")
              },
              {
                job: "Closed",
                count: closedJob,
                color: am4core.color("#eb3528")
              }
            ];
            
            // chart2.innerRadius = am4core.percent(40);
            // chart2.depth = 120;
            
            chart2.legend = new am4charts.Legend();
            
            var series2 = chart2.series.push(new am4charts.PieSeries3D());
            series2.dataFields.value = "count";
            series2.dataFields.depthValue = "count";
            series2.dataFields.category = "job";
            series2.slices.template.cornerRadius = 5;
            series2.colors.step = 3;
            series2.labels.template.disabled = true;
            series2.ticks.template.disabled = true;
            series2.slices.template.propertyFields.fill = "color";
            
            }); // end am4core.ready()
            
            setTimeout(() => {
                $("div div g").each(function(index,element){        
                    if($(this).attr('role') == 'group'){
                        $(this).hide();
                    }     
                    if($(this).attr('shape-rendering') == 'auto'){
                        $(this).hide();
                    }   
                });
            }, 1);
            
            
            // code to create chart
            /**
             * ---------------------------------------
             * This demo was created using amCharts 4.
             *
             * For more information visit:
             * https://www.amcharts.com/
             *
             * Documentation is available at:
             * https://www.amcharts.com/docs/v4/
             * ---------------------------------------
             */
            
            // Apply chart themes
            
            am4core.useTheme(am4themes_animated);
            am4core.useTheme(am4themes_kelly);
            
            // Create chart instance
            var chart = am4core.create("barChart", am4charts.XYChart);
            
            // Add data
            chart.data = dataChart;
            
            // Create axes
            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "year";
            categoryAxis.title.text = "Yearly Statistics";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 100;
            
            var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.title.text = "";
            
            // Create series
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.dataFields.valueY = "company";
            series.dataFields.categoryX = "year";
            series.name = "Company";
            series.tooltipText = "{name}: [bold]{valueY}[/]";
            // This has no effect
             series.stacked = false;
            
            var series2 = chart.series.push(new am4charts.ColumnSeries());
            series2.dataFields.valueY = "candidates";
            series2.dataFields.categoryX = "year";
            series2.name = "candidates";
            series2.tooltipText = "{name}: [bold]{valueY}[/]";
            // Do not try to stack on top of previous series
             series2.stacked = false;
            
            var series3 = chart.series.push(new am4charts.ColumnSeries());
            series3.dataFields.valueY = "jobs";
            series3.dataFields.categoryX = "year";
            series3.name = "jobs";
            series3.tooltipText = "{name}: [bold]{valueY}[/]";
            series3.stacked = false;
            
            // Add cursor
            chart.cursor = new am4charts.XYCursor();
            
            // Add legend
            chart.legend = new am4charts.Legend();
            //end code to create chart
    },
    
}

Post.init();