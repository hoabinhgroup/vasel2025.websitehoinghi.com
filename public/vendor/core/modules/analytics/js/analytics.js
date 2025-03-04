$(window).on("load", function () {
  var ctx = $("#line-stacked-analytics"),
    chartOptions = {
      responsive: !0,
      maintainAspectRatio: !1,
      legend: {
        position: "top",
      },
      hover: {
        mode: "label",
      },
      scales: {
        xAxes: [
          {
            display: !0,
            gridLines: {
              color: "#f3f3f3",
              drawTicks: !1,
            },
            ticks: {
              padding: 15,
            },
            scaleLabel: {
              display: !0,
            },
          },
        ],
        yAxes: [
          {
            display: !0,
            gridLines: {
              color: "#f3f3f3",
              drawTicks: !1,
            },
            ticks: {
              min: 0,
              stepSize: 5,
            },
            scaleLabel: {
              display: !0,
              labelString: "Giá trị",
            },
          },
        ],
      },
      title: {
        display: !0,
        text: "",
      },
    },
    chartData = {
      labels: dataStatsAnalytics,
      datasets: [
        {
          label: "Lượt xem",
          data: pageviews,
          backgroundColor: "rgba(22,211,154,.5)",
          borderColor: "transparent",
          pointBorderColor: "#16D39A",
          pointBackgroundColor: "#FFF",
          pointBorderWidth: 2,
          pointHoverBorderWidth: 2,
          pointRadius: 4,
        },
        {
          label: "Lượt truy cập",
          data: visitors,
          backgroundColor: "rgba(249,142,118,.5)",
          borderColor: "transparent",
          pointBorderColor: "#F98E76",
          pointBackgroundColor: "#FFF",
          pointBorderWidth: 2,
          pointHoverBorderWidth: 2,
          pointRadius: 4,
        },
      ],
    },
    config = {
      type: "line",
      options: chartOptions,
      data: chartData,
    };
  new Chart(ctx, config);
});
