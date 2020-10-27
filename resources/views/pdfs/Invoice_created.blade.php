
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
    .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;
  height: 29.7cm;
  margin: 0 auto;
  color: #001028;
  background: #FFFFFF;
  font-family: Arial, sans-serif;
  font-size: 12px;
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 20%;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;
}

table {
  width: 90%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="images/logo.jpg">
      </div>
      <h1>INVOICE {{$get_docentry->DocNum}}</h1>
      <div id="company" class="clearfix">
        <div>Ideal Ceramics</div>
        <div>Mombasa Road,<br /> Nairobi, Kenya</div>
        <div>07046924242</div>
        <div><a href="mailto:company@example.com">info@idealceramics.com</a></div>
      </div>
      <div id="project">
        <div><span>CLIENT</span> {{$get_email->CardName}}</div>
        <div><span>ADDRESS</span> Nairobi</div>
        <div><span>EMAIL</span> <a href="mailto:john@example.com"></a>{{$get_email->Cellular}}</div>
        <div><span>DATE</span> {{$get_docentry->DocDate}}</div>
        <div><span>DUE DATE</span> {{$get_docentry->DocDueDate}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
        @foreach($products as $item)
          <tr>
            <td class="service">{{$item->ItemCode}}</td>
            <td class="desc">{{$item->Dscription}}</td>
            <td class="unit">{{$item->Price}}</td>
            <td class="qty">{{$item->Quantity}}</td>
            <td class="total">Ksh {{$item->LineTotal}}</td>
          </tr>
        @endforeach
          <tr>
            <td colspan="4">SUBTOTAL</td>
            <td class="total">{{$get_docentry->DocTotal - $get_docentry->VatSum}}</td>
          </tr>
          <tr>
            <td colspan="4">TAX {{$get_docentry->VatPercent}}</td>
            <td class="total">{{$get_docentry->VatSum}}</td>
          </tr>
          <tr>
            <td colspan="4" class="grand total">GRAND TOTAL</td>
            <td class="grand total">{{$get_docentry->DocTotal}}</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
