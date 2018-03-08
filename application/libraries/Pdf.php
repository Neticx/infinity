<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');

function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

class pdf extends FPDF {

    private $dataAlamat = array('judul'=>'','alamat' => '','region' => '','telp' => '','email' => '',);
    private $widths;

    function __construct($orientation='P', $unit='mm', $size='A4', $data = array()){
        parent::__construct($orientation,$unit,$size);
        foreach($data as $key => $value){
            $this->dataAlamat[$key] = $value;
        }
    }

    function Header(){
        $lebar = $this->w;
        $this->Image('assets/images/logo.png',25,15,30);
        $this->Cell(40);
        $this->SetFont('Arial','B',24);
        $this->SetTextColor(22,113,225);
        $w = $this->GetStringWidth($this->dataAlamat['judul']);
        $this->Cell($w,9,$this->dataAlamat['judul'],0,0,'C');
        $this->Ln(8);
        $this->Cell(40);
        $this->SetFont('Arial','',11);
        $this->SetTextColor(0,0,0);
        $this->MultiCell(0,5,$this->dataAlamat['alamat']);
        //$this->Ln(5);
        $this->Cell(40);
        $this->MultiCell(0,5,$this->dataAlamat['region']);
        //$this->Ln(5);
        $this->SetFont('Arial','B',11);
        $this->Cell(40);
        $this->MultiCell(0,5,(!empty($this->dataAlamat['telp'])?"Telp : ".$this->dataAlamat['telp']:"")." | ".(!empty($this->dataAlamat['email'])?"E-mail : ".$this->dataAlamat['email']:""));
        $this->Ln(5);
        $this->line($this->GetX(), $this->GetY(), $this->GetX()+($lebar-40), $this->GetY());
        $this->Ln(5);
    }


    function Footer() {
        $this->SetY(-15);
        $lebar = $this->w;
        $this->SetFont('Arial','I',8);
        $this->line($this->GetX(), $this->GetY(), $this->GetX()+$lebar-40, $this->GetY());
        $this->SetY(-15);
        $this->SetX(0);
        $this->Ln(1);
        $hal = 'Page : '.$this->PageNo().'/{nb}';
        $this->Cell($this->GetStringWidth($hal ),10,$hal );
        $datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
        $tanggal  = 'Printed : '.date('d-m-Y  h:i-a').' ';
        $this->Cell($lebar-$this->GetStringWidth($hal )-$this->GetStringWidth($tanggal)-40);
        $this->Cell($this->GetStringWidth($tanggal),10,$tanggal );
    }

    function SetWidths($w){
        //Set the array of column widths
        $this->widths=$w;
    }

    function Row($data){
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i][0]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($data[$i][1]) ? $data[$i][1] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i][0],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function RowNoBorder($data){
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i][0]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($data[$i][1]) ? $data[$i][1] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            //$this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i][0],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h){
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt){
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

}