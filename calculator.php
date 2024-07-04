<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mortgage Calculator - ENSO</title>
 <link rel="canonical" href="https://www.enso.inc/calculator.php" />
    <meta name="description" content="Calculate your monthly payments effortlessly with ENSO's user-friendly mortgage calculator. Plan your finances confidently today!" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://www.enso.inc/assets/images/Enzo-banner-logo.png">
    <meta property="og:title" content="Mortgage Calculator - ENSO" />
    <meta property="og:description" content="Calculate your monthly payments effortlessly with ENSO's user-friendly mortgage calculator. Plan your finances confidently today!" />
    <meta property="og:url" content="https://www.enso.inc/calculator.php" />
    <meta property="og:site_name" content="ENSO" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Calculate your monthly payments effortlessly with ENSO's user-friendly mortgage calculator. Plan your finances confidently today!" />
    <meta name="twitter:title" content="Mortgage Calculator - ENSO" />
    <meta name="twitter:image" content="https://www.enso.inc/assets/images/Enzo-banner-logo.png" />


<!-- _______ Include Common CSS AND META TAG _______ -->
<?php include 'style_css.php'?>
<!-- _______ CSS END _______ -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<figure class="highcharts-figure">
</figure>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KNM4K7M5');</script>
<!-- End Google Tag Manager -->
</head>
<style type="text/css">
  #container {
    height: 400px;
    margin-bottom:50px;
  }

  .highcharts-figure,
  .highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
  }

  .highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
  }

  .highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
  }

  .highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
    padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
    background: #f1f7ff;
  }
</style>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNM4K7M5"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->  
<!-- __________ HEADER __________ -->
<?php include 'header.php'?>
<!-- __________ HEADER END __________ -->
<div class="grid">
<div class="grid-line"></div>
<div class="grid-line"></div>
<div class="grid-line"></div>
<div class="grid-line"></div>
<div class="grid-line"></div>
</div>
<!-- <section class="calculator-banner">
<div class="container">
<div data-aos="fade-down">
<h1>Mortgage Calculator</h1>   
</div>
</div>
</section> -->
<section class="padding100 margin100 sustain-section">
    <div class="container">
        <div class="about-us about-page-text calculator-text">
        <h2 data-aos="fade-up" data-aos-delay="300">Calculate your Mortgage Requirements</h2>
        <p data-aos="fade-up" data-aos-delay="500">Use the calculator below to get a comprehensive overview</p>
        
        <div class="svg-shad about-us-svg"><img src="assets/images/banner-icon.svg"></div>
        </div>  
    </div>
</section>
<section class="calculator-graph">
    <div class="container">
    <?php include 'calculator_form.php'?>

</div>
</section>


<!-- __________ FOOTER __________ -->
<?php include 'footer.php'?>
<!-- __________ FOOTER END __________ -->

<!-- __________ Include JS __________ -->
<?php include 'style_js.php'?>
<!-- __________ JS END __________ -->

<script>
  
function myFunction() {
  var element = document.body;
  element.classList.toggle("dark-mode");
}


const loanAmountInput = document.querySelector(".loan-amount");
const interestRateInput = document.querySelector(".interest-rate");
const loanTenureInput = document.querySelector(".loan-tenure");
//const processingFeeInput = document.querySelector(".processing-fee");
const downPaymentInput = document.querySelector(".down-payment");

const loanEMIValue = document.querySelector(".monthly-Payment .value");
//const totalInterestValue = document.querySelector(".total-interest .value");
const HomeownerInsuranceValue = $('#homeowner_insurance').val();
// const totalAmountValue = document.querySelector(".total-amount .value");
//const totalDownPaymentValue = document.querySelector(".total-down-payment .value");
const propertyTaxValue = $('#property_tax').val();

const calculateBtn = document.querySelector(".calculate-btn");

let loanAmount = parseFloat(loanAmountInput.value);
let newAmount = 0;
for (let i = 0; i < 1; i++) {
  newAmount = loanAmount;
}
let interestRate = parseFloat(interestRateInput.value);
let loanTenure = parseFloat(loanTenureInput.value);
//let processingFee = parseFloat(processingFeeInput.value);
let downPayment = parseFloat(downPaymentInput.value);

let interest = interestRate / 12 / 100;
//let processFee = processingFee / 100;

let myChart;

const checkValues = () => {
  let loanAmountValue = loanAmountInput.value;
  let interestRateValue = interestRateInput.value;
  let loanTenureValue = loanTenureInput.value;
  //let processingFeeValue = processingFeeInput.value;
  let downPaymentValue = downPaymentInput.value;

  let regexNumber = /^[0-9]+$/;
  if (!loanAmountValue.match(regexNumber)) {
    loanAmountInput.value = "";
  }

  if (!loanTenureValue.match(regexNumber) || loanTenureValue > 360) {
    loanTenureInput.value = "";
  }

  if (!downPaymentValue.match(regexNumber) || downPaymentValue > newAmount) {
    downPaymentInput.value = downPaymentValue;
  }

  let regexDecimalNumber = /^(\d*\.)?\d+$/;
  if (!interestRateValue.match(regexDecimalNumber)) {
    interestRateInput.value = "";
  }
  // if (!processingFeeValue.match(regexDecimalNumber)) {
  //   processingFeeInput.value = "0";
  // }
  if (parseInt(downPaymentValue) > parseInt(loanAmountValue)) {
    alert("Down Payment Should be Less Than Loan Amount!");
    $('.down-payment').val(0);
  }
};

const displayChart = (emi, principal, Interest) => {
  const canvas = document.getElementById("myChart");
  const ctx = canvas.getContext("2d");

  // Check if the canvas is already in use and clear it
  if (canvas.chart) {
    canvas.chart.destroy();
  }

  const total = parseInt(emi);
  //alert(total);
  const data = {
    labels: ["Principle", "Interest" ],
    datasets: [{
      data: [principal, Interest],
      backgroundColor: ["#CCCCCC", "#888888"],
      borderWidth: 0,
    }]
  };

  const options = {
    plugins: {
      // Custom text display plugin
      customText: {
        text: 'Total: ' + total,
        color: '#000',
        font: {
          size: 20,
          family: 'Arial'
        },
        // Adjust position as needed
        position: 'center'
      }
    }
  };

  // Extend Chart.js with custom text display plugin
  Chart.register({
    id: 'customText',
    beforeDraw: chart => {
      const { ctx, chartArea } = chart;
      const { text, color, font, position } = chart.options.plugins.customText;

      if (position === 'center') {
        const centerX = (chartArea.left + chartArea.right) / 2;
        const centerY = (chartArea.top + chartArea.bottom) / 2;

        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = color;
        ctx.font = `${font.size}px ${font.family}`;
        ctx.fillText(text, centerX, centerY);
      }
    }
  });

  // Create chart instance
  canvas.chart = new Chart(ctx, {
    type: "doughnut",
    data: data,
    options: options
  });
};

function calculateMortgage() {
  const principal = loanAmount
  const annualInterestRate = parseFloat(interestRate) / 100;
  //const term = parseInt(document.getElementById('term').value);
  const term = parseFloat(loanTenureInput.value);
  const startDate = new Date(document.getElementById('startDate').value);

  const endDate = new Date(startDate);
  endDate.setFullYear(startDate.getFullYear() + 25);
  // Array of month names
  const months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
  // Get day, month, and year components
  const day = endDate.getDate();
  const monthIndex = endDate.getMonth();
  const year = endDate.getFullYear();
  // Format the date
  const formattedEndDate = `${day} ${months[monthIndex]} ${year}`;
  $("#end_date").append(formattedEndDate);

  const monthlyInterestRate = annualInterestRate / 12;
  const numberOfPayments = term * 12;
  const monthlyPayment = principal * monthlyInterestRate / (1 - Math.pow(1 + monthlyInterestRate, -numberOfPayments));

  let remainingBalance = principal;
  let totalInterest = 0;
  let interestPaidData = []; // To store interest paid data for the chart
  let principalPaidData = []; // To store interest paid data for the chart
  let remainingBalanceData = []; // To store interest paid data for the chart
  let totalPrincipalData = []; // To store interest paid data for the chart

  let resultHtml = '<h2>Year-wise Mortgage Data</h2>';
  resultHtml += '<table border="1"><tr><th>Year</th><th>Annual Payment</th><th>Interest Paid</th><th>Principal Paid</th><th>Remaining Balance</th></tr>';

  let totalPrincipalPaid = 0; // Variable to accumulate the principal paid over the years

  for (let year = startDate.getFullYear(); year <= endDate.getFullYear(); year++) {
      let annualPayment = 0;
      let interestPaidYearly = 0;
      let principalPaidYearly = 0;

      for (let month = 0; month < 12; month++) {
          const interestForMonth = remainingBalance * monthlyInterestRate;
          const principalForMonth = monthlyPayment - interestForMonth;
          interestPaidYearly += interestForMonth;
          principalPaidYearly += principalForMonth;
          remainingBalance -= principalForMonth;
      }

      totalInterest += interestPaidYearly;
      annualPayment = principalPaidYearly + interestPaidYearly;
      totalPrincipalPaid += principalPaidYearly; // Accumulate principal paid over the years
      interestPaidData.push(Math.round(interestPaidYearly)); // Collecting interest paid data
      principalPaidData.push(Math.round(principalPaidYearly)); // Collecting principal paid data
      remainingBalanceData.push(Math.round(remainingBalance)); // Collecting remaining balance data
      totalPrincipalData.push(Math.round(totalPrincipalPaid)); // Collecting remaining balance data
      resultHtml += `<tr><td>${year}</td><td>${annualPayment.toFixed(2)}</td><td>${interestPaidYearly.toFixed(2)}</td><td>${principalPaidYearly.toFixed(2)}</td><td>${remainingBalance.toFixed(2)}</td></tr>`;

      if (remainingBalance <= 0) {
          break; // Loan fully paid off
      }
      $('#annual_amount').val(Math.round(annualPayment));
    //alert(annualPayment);
  }


  resultHtml += '</table>';
  resultHtml += `<p>Total Interest Paid: ${totalInterest.toFixed(2)}</p>`;

  //document.getElementById('result').innerHTML = resultHtml;

  Highcharts.chart('container', {
    chart: {
      type: 'areaspline'
    },
    title: {
      text: "Mortgage payoff year's "+startDate.getFullYear()+" - "+endDate.getFullYear(),
      align: 'left'
    },
    subtitle: {
      //text: '',
      align: 'left'
    },
    legend: {
      layout: 'vertical',
      align: 'left',
      verticalAlign: 'top',
      x: 120,
      y: 70,
      floating: true,
      borderWidth: 1,
      backgroundColor:
        Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
      plotBands: [{ // Highlight the two last years
        from: startDate.getFullYear(),
        to: endDate.getFullYear(),
        color: 'rgba(68, 170, 213, .2)'
      }]
    },
    yAxis: {
      title: {
        text: 'Rate'
      },
      min: 0 // Setting the minimum value of the y-axis to 0
    },
    tooltip: {
      shared: true,
      headerFormat: '<b>{point.x}</b><br>'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      series: {
        pointStart: startDate.getFullYear()
      },
      areaspline: {
        fillOpacity: 0.5
      }
    },
    series: [{
      name: 'Principal Paid',
      data:totalPrincipalData
    }, {
      name: 'Interest Paid',
      data:interestPaidData
    },{
      name: 'Remaining Balance',
      data:remainingBalanceData
    }]
  });
}




const updateChart = (homeowner_insurance, emi, property_tax) => {
  myChart.data.datasets[0].data[0] = emi;
  //myChart.data.datasets[0].data[1] = property_tax;
 //myChart.data.datasets[0].data[2] = homeowner_insurance;
  myChart.update();
};

const refreshInputValues = () => {
  loanAmount = parseFloat(loanAmountInput.value);
  interestRate = parseFloat(interestRateInput.value);
  //loanTenure = parseFloat(loanTenureInput.value);
  loanTenure = parseFloat(loanTenureInput.value) * 12;
  //processingFee = parseFloat(processingFeeInput.value);
  downPayment = parseFloat(downPaymentInput.value);
  interest = interestRate / 12 / 100;
  //processFee = processingFee / 100;
};

const calculateEMI = () => {
  checkValues();
  refreshInputValues();
  loanAmount = loanAmount - downPayment;
  
  // let emi =
  //   loanAmount *
  //   interest *
  //   (Math.pow(1 + interest, loanTenure) /
  //     (Math.pow(1 + interest, loanTenure) - 1));
  let emi = (loanAmount * interest) / (1 - Math.pow(1 + interest, -loanTenure));
  return emi;

};
// $('#property_tax').on('keyup', function() {
//   const featch_emi = document.querySelector(".loan-emi .value");
//   featch_emi_value = loanEMIValue.innerHTML
//   let property_tax = $(this).val();
//   let homeowner_insurance = $("#homeowner_insurance").val();
//   updateData(featch_emi_value, homeowner_insurance, property_tax);
// });
// $('#homeowner_insurance').on('keyup', function() {
//   const featch_emi = document.querySelector(".loan-emi .value");
//   featch_emi_value = loanEMIValue.innerHTML
//   let homeowner_insurance = $(this).val();
//   let property_tax = $("#property_tax").val();
//   updateData(featch_emi_value, homeowner_insurance, property_tax);
// });

const updateData = (emi) => {
  let year = parseFloat(loanTenureInput.value);
  //alert(year);
  $("#emi_year").append(Math.ceil(emi)+ " AED for "+year+" years");
  $("#t_interest_cal").append("Total Payment ("+Math.ceil(emi)+" x "+loanTenure+" Installments)");
  let t_interest =  Math.ceil(emi) * loanTenure;
  $("#t_interest").append(t_interest);
  let only_interest = t_interest - loanAmount;
  $("#only_interest").append(only_interest);

  loanEMIValue.innerHTML = Math.ceil(emi);

  let interest_rate = $('#interest_rate').val();
  var percentage_val = (interest_rate / 100) * loanAmount;
  //alert(percentage_val);
  //let processingFees = Math.ceil(loanAmount * processFee);

  //let property_tax = propertyTaxValue;
  //$('#property_tax').val(property_tax);
  //totalDownPaymentValue.innerHTML = totalDownPay;

  let totalAmount = Math.ceil(loanTenure * emi);
  // totalAmountValue.innerHTML = totalAmount;

  //let homeowner_insurance = HomeownerInsuranceValue;
  //$('#homeowner_insurance').val(homeowner_insurance);
  //totalInterestValue.innerHTML = totalInterestPayable;
  let emi_graph = Math.ceil(emi);
  if (myChart) {
    updateChart(emi_graph);
  } else {
    displayChart(emi_graph, loanAmount, percentage_val);
    calculateMortgage(emi_graph);
  }
};

const init = () => {
  $("#emi_year").html('');
  $("#t_interest_cal").html('');
  $("#t_interest").html('');
  $("#only_interest").html('');
  $("#end_date").html('');
  let emi = calculateEMI();
  updateData(emi);
};

init();
function incrementValue() {
  var input = document.getElementById('inCost');
  var value = parseInt(input.value);
  value += 50000;
  input.value = value;
  var advance_p = $("#advance_p").val();
    //principalInput = $(this).val(); 
    var percentage_val = (advance_p / 100) * value;
    $("#down-payment").val(percentage_val);
    init();
}
function decrementValue() {
  var input = document.getElementById('inCost');
  var value = parseInt(input.value);
  if (value >= 50000) {
      value -= 50000;
      input.value = value;
  }
  var advance_p = $("#advance_p").val();
    //principalInput = $(this).val(); 
    var percentage_val = (advance_p / 100) * value;
    $("#down-payment").val(percentage_val);
    init();
}

function incrementValueIR() {
    var input = document.getElementById('interest_rate');
    var value = parseFloat(input.value);
    value += 0.01; // Increase by 0.01 (1%)
    input.value = value.toFixed(2); // Round to 2 decimal places
    init();
}

function decrementValueIR() {
    var input = document.getElementById('interest_rate');
    var value = parseFloat(input.value);
    if (value > 0) {
        value -= 0.01; // Decrease by 0.01 (1%)
        input.value = value.toFixed(2); // Round to 2 decimal places
    }
    init();
}
//calculateBtn.addEventListener("click", init);
var rangeInput1 = document.getElementById("range1");
var rangeInput2 = document.getElementById("range2");

// Add event listeners for the input event
rangeInput1.addEventListener("input", init);
rangeInput2.addEventListener("input", init);

// Select the input element
var inCostInput = document.getElementById("inCost");
var interest_rateInput = document.getElementById("interest_rate");

// Add an event listener for the keyup event
//inCostInput.addEventListener("keyup", init);
inCostInput.addEventListener("keyup", function() {
    var advance_p = $("#advance_p").val();
    principalInput = $(this).val(); 
    var percentage_val = (advance_p / 100) * principalInput;
    $("#down-payment").val(percentage_val);
    init();
});
interest_rateInput.addEventListener("keyup", init);

var startDate = document.getElementById("startDate");
startDate.addEventListener("change", init);

</script>
<script>
 AOS.init({
        duration: 1200,
        once: true,
    });
</script>
</body>
</html>