
<style>
    body {
        background: rgb(204,204,204);               
    }


    page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
        size: A4
    }
    @page { counter-increment: page }
    #pageCounter {
        counter-reset: pages;        
    }
    #pageCounter .page:before {
        counter-increment: pages; 
    }
    #pageCounter .page:after {         
        content: " " counter(page) " of " counter(pages);
    }

    /*    #pageNumbers {
            counter-reset: currentPage;
            width:500px;
            background:#000;
            margin:auto;
            color:#fff;
            padding:30px
    
        }
        #pageNumbers div:before { 
            counter-increment: currentPage; 
            content:  counter(currentPage) " / "; 
        }
        #pageNumbers div:after { 
            content: counter(pageTotal); 
        }
        .page-number{
            display:block;
            font-size:20px;
            margin:20px;
            text-align:center;
            border-bottom:1px solid #555
        }
        .page-number:after{
            counter-increment: page;
        }*/
    @media print {
        body, page {
            margin: 0;
            box-shadow: 0;
        }

    }
    @page {
        @top-right {
            content: counter(page) " / " counter(pages);
        }
    }
    .page{        
        page-break-after: always;
    }
    /*    .page:after{
            counter-increment: page;
            content: counter(currentPage) " / " pageTotal; 
        }*/
</style>
<div id="pageCounter">
    <div class="page">First Page</div>
    <div class="page">Second Page</div>
    <div class="page">Third Page</div>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "page {PAGE_NUM} of {PAGE_COUNT}";        
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</div>
<!--<div id="pageNumbers">
    <div class="page-number"></div>
    <div class="page-number"></div>
    <div class="page-number"></div>
</div>-->
