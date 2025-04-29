<?php
require('contactform/class/class.fpdf.php');

class FPDF_CellFit extends FPDF {

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }

}

$timestamp = time();
$datum = date("d.m.Y", $timestamp);

$pdf2 = new FPDF_CellFit();
  $txt_long = 'This text is way too longThis text is way too long';
  $pdf2->AddPage();
  $pdf2->Image('sepa3.png',0,0,210,0);
  $pdf2->SetFont('Arial','B',14); 
  $pdf2->ln(168);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,$txt_long,0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,$txt_long,0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,$txt_long,0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(107,8,$txt_long,0,1,'',0);
  $pdf2->ln(1);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(107,8,$txt_long,0,1,'',0);
  $pdf2->ln(24);
  $pdf2->Cell(2);
  $pdf2->CellFitScale(65,8,$txt_long,0,1,'',0);  
  
  //PDF anhängen
  $antrag = $pdf2->Output();
?>
