<html>
<head>
    <style>

@import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
*{
  margin: 0;
  box-sizing: border-box;

}
body{
  background-color: black;
  font-family: 'Roboto', sans-serif;
  background-repeat: repeat-y;
  background-size: 100%;
}
::selection {background: #f31544; color: #FFF;}
::moz-selection {background: #f31544; color: #FFF;}
h1{
  font-size: 1.5em;
  color: #222;
}
h2{font-size: .9em;}
h3{
  font-size: 1.2em;
  font-weight: 300;
  line-height: 2em;
}
p{
  font-size: 1.1em;
  color: #666;
  line-height: 1.2em;
}

#invoiceholder{
  width:100%;
  height: 100%;
  padding-top: 50px;
}

#invoice{
  position: relative;
  top: -290px;
  margin: 0 auto;
  width: 700px;
  background: #FFF;
}

[id*='invoice-']{ /* Targets all id with 'col-' */
  border-bottom: 1px solid #EEE;
  padding: 30px;
}

#invoice-top{min-height: 120px;}
#invoice-mid{min-height: 120px;}
#invoice-bot{ min-height: 250px;}


.info{
  display: block;
  float:left;
  margin-left: 20px;
}
.title{
  float: right;
}
.title p{text-align: right;}
#project{margin-left: 52%;}
table{
  width: 100%;
  border-collapse: collapse;
}
td{
  padding: 5px 0 5px 15px;
  border: 1px solid #EEE
}
.tabletitle{
  padding: 5px;
  background: #167BA1;
  color:white;
}
.headDoc{
  padding: 15px;
  background: #167BA1;
  color:white;
}
.service{border: 1px solid #EEE;}
.item{width: 50%;}
.itemtext{font-size: 1.1em;}

#legalcopy{
  margin-top: 30px;
}
form{
  float:right;
  margin-top: 30px;
  text-align: right;
}
.effect2
{
  position: relative;
}
.effect2:before, .effect2:after
{
  z-index: -1;
  position: absolute;
  content: "";
  bottom: 15px;
  left: 10px;
  width: 50%;
  top: 80%;
  max-width:300px;
  background: #777;
  -webkit-box-shadow: 0 15px 10px #777;
  -moz-box-shadow: 0 15px 10px #777;
  box-shadow: 0 15px 10px #777;
  -webkit-transform: rotate(-3deg);
  -moz-transform: rotate(-3deg);
  -o-transform: rotate(-3deg);
  -ms-transform: rotate(-3deg);
  transform: rotate(-3deg);
}
.effect2:after
{
  -webkit-transform: rotate(3deg);
  -moz-transform: rotate(3deg);
  -o-transform: rotate(3deg);
  -ms-transform: rotate(3deg);
  transform: rotate(3deg);
  right: 10px;
  left: auto;
}

.legal{
  width:70%;
}
    </style>
</head>
<div id="invoiceholder">


  <div id="invoice" class="effect2">

    <div class="headDoc">
            <td class="Rate" style="float:right; font-size: 1.3em"><h2>Invoice Number: {{$invoice->DocNum}}</h2></td>
    </div>
    <div class="message" style="padding:15px">
    <p>Hello {{$customer->CardName}},<br>
    <br>
        Your goods have been dispatched and you should expect your delivery by 5pm today. item(s) have been dispatched.</p>
    </div>


    <div id="invoice-bot">

      <div id="table">
        <table>
          <tr class="tabletitle">
            <td class="item"><h2>Item Description</h2></td>
            <td class="Hours"><h2>Quantity</h2></td>
            <td class="Rate"><h2>Price</h2></td>
            <td class="subtotal"><h2>Total</h2></td>
          </tr>

        @foreach($items as $item)
          <tr class="service">
            <td class="tableitem"><p class="itemtext">{{$item->Dscription}}</p></td>
            <td class="tableitem"><p class="itemtext">{{number_format((float)$item->Quantity, 2, '.', '')}}</p></td>
            <td class="tableitem"><p class="itemtext">{{number_format((float)$item->Price, 2, '.', '')}}</p></td>
            <td class="tableitem"><p class="itemtext">{{number_format((float)$item->LineTotal, 2, '.', '')}}</p></td>
          </tr>
        @endforeach

          <tr class="tabletitle">
            <td></td>
            <td></td>
            <td class="Rate"><h2>Total</h2></td>
            <td class="payment"><h2>{{number_format((float)$invoice->DocTotal, 2, '.', '')}}</h2></td>
          </tr>

        </table>
      </div><!--End Table-->

      <div id="legalcopy">
        <p class="legal" style="align:center">Thank you for your business!
        </p>
      </div>

    </div><!--End InvoiceBot-->
  </div><!--End Invoice-->
</div><!-- End Invoice Holder-->
</body>
</html>
