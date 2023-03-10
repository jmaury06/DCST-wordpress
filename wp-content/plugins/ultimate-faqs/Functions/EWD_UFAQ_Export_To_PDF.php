<?php 
function EWD_UFAQ_Export_To_PDF() {
	// make sure that the request is coming from the admin form
    if ( ! isset( $_POST['EWD_UFAQ_Export_PDF_Nonce'] ) ) { return; }
    if ( ! wp_verify_nonce( $_POST['EWD_UFAQ_Export_PDF_Nonce'], 'EWD_UFAQ_Export_PDF' ) ) { return; }

		require_once(EWD_UFAQ_CD_PLUGIN_PATH . '/FPDF/fpdf.php');
		
		if ($Category != "EWD_UFAQ_ALL_CATEGORIES") {
			$category_array = array( 
				'taxonomy' => 'ufaq-category',
				'field' => 'slug',
				'terms' => $Category->slug
			);
		}

		$params = array(
			'posts_per_page' => -1,
			'post_type' => 'ufaq'
		);
		$faqs = get_posts($params);

		$PDFPasses = array("FirstPageRun", "SecondPageRun", "Final");
		foreach ($PDFPasses as $PDFRun) {
				$pdf = new FPDF();
				$pdf->AddPage();

				if ($PDFRun == "SecondPageRun" or $PDFRun == "Final") {
					  $pdf->SetFont('Arial','B',14);
						$pdf->Cell(20, 10, "Page #");
						$pdf->Cell(20, 10, "Article Title");
						$pdf->Ln();
						$pdf->SetFont('Arial','',12);

						foreach ($ToC as $entry) {
								$pdf->Cell(20, 5, "  " . utf8_decode($entry['page']));
								$pdf->MultiCell(0, 5, utf8_decode($entry['title']));
								$pdf->Ln();
						}

						unset($ToC);
				}

				foreach ($faqs as $faq) {
						$PostTitle = em(strip_tags(html_entity_decode($faq->post_title)));

						$PostText = em(strip_tags(html_entity_decode($faq->post_content)));
						$PostText = str_replace("&#91;", "[", $PostText);
						$PostText = str_replace("&#93;", "]", $PostText);

						$pdf->AddPage();

						$Entry['page'] = $pdf->page;
						$Entry['title'] = $PostTitle;

						$pdf->SetFont('Arial','B',15);
						$pdf->MultiCell(0, 10, $PostTitle);
						$pdf->Ln();
						$pdf->SetFont('Arial','',12);
						$pdf->MultiCell(0, 10, $PostText);

						$ToC[] = $Entry;
						unset($Entry);
				}

				if ($PDFRun == "FirstPageRun" or $PDFRun == "SecondPageRun") {
					  $pdf->Close();
				}

				if ($PDFRun == "Final") {
		 			  $pdf->Output('Ultimate-FAQ-Manual.pdf', 'D');
				}
		}
}

function em($word) {

    $word = str_replace("@","%40",$word);
    $word = str_replace("`","%60",$word);
    $word = str_replace("??","%A2",$word);
    $word = str_replace("??","%A3",$word);
    $word = str_replace("??","%A5",$word);
    $word = str_replace("|","%A6",$word);
    $word = str_replace("??","%AB",$word);
    $word = str_replace("??","%AC",$word);
    $word = str_replace("??","%AD",$word);
    $word = str_replace("??","%B0",$word);
    $word = str_replace("??","%B1",$word);
    $word = str_replace("??","%B2",$word);
    $word = str_replace("??","%B5",$word);
    $word = str_replace("??","%BB",$word);
    $word = str_replace("??","%BC",$word);
    $word = str_replace("??","%BD",$word);
    $word = str_replace("??","%BF",$word);
    $word = str_replace("??","%C0",$word);
    $word = str_replace("??","%C1",$word);
    $word = str_replace("??","%C2",$word);
    $word = str_replace("??","%C3",$word);
    $word = str_replace("??","%C4",$word);
    $word = str_replace("??","%C5",$word);
    $word = str_replace("??","%C6",$word);
    $word = str_replace("??","%C7",$word);
    $word = str_replace("??","%C8",$word);
    $word = str_replace("??","%C9",$word);
    $word = str_replace("??","%CA",$word);
    $word = str_replace("??","%CB",$word);
    $word = str_replace("??","%CC",$word);
    $word = str_replace("??","%CD",$word);
    $word = str_replace("??","%CE",$word);
    $word = str_replace("??","%CF",$word);
    $word = str_replace("??","%D0",$word);
    $word = str_replace("??","%D1",$word);
    $word = str_replace("??","%D2",$word);
    $word = str_replace("??","%D3",$word);
    $word = str_replace("??","%D4",$word);
    $word = str_replace("??","%D5",$word);
    $word = str_replace("??","%D6",$word);
    $word = str_replace("??","%D8",$word);
    $word = str_replace("??","%D9",$word);
    $word = str_replace("??","%DA",$word);
    $word = str_replace("??","%DB",$word);
    $word = str_replace("??","%DC",$word);
    $word = str_replace("??","%DD",$word);
    $word = str_replace("??","%DE",$word);
    $word = str_replace("??","%DF",$word);
    $word = str_replace("??","%E0",$word);
    $word = str_replace("??","%E1",$word);
    $word = str_replace("??","%E2",$word);
    $word = str_replace("??","%E3",$word);
    $word = str_replace("??","%E4",$word);
    $word = str_replace("??","%E5",$word);
    $word = str_replace("??","%E6",$word);
    $word = str_replace("??","%E7",$word);
    $word = str_replace("??","%E8",$word);
    $word = str_replace("??","%E9",$word);
    $word = str_replace("??","%EA",$word);
    $word = str_replace("??","%EB",$word);
    $word = str_replace("??","%EC",$word);
    $word = str_replace("??","%ED",$word);
    $word = str_replace("??","%EE",$word);
    $word = str_replace("??","%EF",$word);
    $word = str_replace("??","%F0",$word);
    $word = str_replace("??","%F1",$word);
    $word = str_replace("??","%F2",$word);
    $word = str_replace("??","%F3",$word);
    $word = str_replace("??","%F4",$word);
    $word = str_replace("??","%F5",$word);
    $word = str_replace("??","%F6",$word);
    $word = str_replace("??","%F7",$word);
    $word = str_replace("??","%F8",$word);
    $word = str_replace("??","%F9",$word);
    $word = str_replace("??","%FA",$word);
    $word = str_replace("??","%FB",$word);
    $word = str_replace("??","%FC",$word);
    $word = str_replace("??","%FD",$word);
    $word = str_replace("??","%FE",$word);
    $word = str_replace("??","%FF",$word);
    return urldecode($word);
}
?>
