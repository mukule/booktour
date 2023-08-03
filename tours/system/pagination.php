<?php
class Pagination {

	function paginate_one( $reload, $page, $tpages ) {
	
		$firstlabel = "First";
		$prevlabel  = "Prev";
		$nextlabel  = "Next";
		$lastlabel  = "Last";
	
		$out = "<div class=\"pagin\">\n";
		
		// first
		if( $page > 1 ) 
			$out .= "<a href=\"" . $reload . "\">" . $firstlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $firstlabel . "</span>\n";
		
		
		// previous
		if( $page == 1 ) 
			$out .= "<span>" . $prevlabel . "</span>\n";
		
		elseif( $page == 2 ) 
			$out .= "<a href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
		
		else 
			$out .= "<a href=\"" . $reload . "&amp;page=" . ( $page - 1 ) . "\">" . $prevlabel . "</a>\n";
		
		
		// current
		$out .= "<span class=\"current\">Page " . $page . " of " . $tpages . "</span>\n";
		
		// next
		if( $page < $tpages ) 
			$out .= "<a href=\"" . $reload . "&amp;page=" .( $page + 1 ) . "\">" . $nextlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $nextlabel . "</span>\n";
		
		
		// last
		if( $page < $tpages ) 
			$out .= "<a href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $lastlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $lastlabel . "</span>\n";
		
		
		$out .= "</div>";
		
		return $out;
	}

	function paginate_two( $reload, $page, $tpages, $adjacents ) {
	
		$firstlabel = "&laquo;&nbsp;";
		$prevlabel  = "&lsaquo;&nbsp;";
		$nextlabel  = "&nbsp;&rsaquo;";
		$lastlabel  = "&nbsp;&raquo;";
		
		$out = "<div class=\"pagin\">\n";
		
		// first
		if( $page > ( $adjacents + 1 ) ) 
			$out .= "<a href=\"" . $reload . "\">" . $firstlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $firstlabel . "</span>\n";
		
		
		// previous
		if( $page == 1 ) 
			$out .= "<span>" . $prevlabel . "</span>\n";
		
		elseif( $page == 2 ) 
			$out .= "<a href=\"" . $reload . "\">" . $prevlabel . "</a>\n";
		
		else 
			$out .= "<a href=\"" . $reload . "&amp;page=" . ( $page - 1 ) . "\">" . $prevlabel . "</a>\n";
		
		
		// 1 2 3 4 etc
		$pmin = ( $page > $adjacents ) ? ( $page - $adjacents ) : 1;
		$pmax = ( $page < ( $tpages - $adjacents ) ) ? ( $page + $adjacents ) : $tpages;
		for( $i=$pmin; $i<=$pmax; $i++ ) :
			if( $i == $page ) 
				$out .= "<span class=\"current\">" . $i . "</span>\n";
			
			elseif( $i == 1 ) 
				$out .= "<a href=\"" . $reload . "\">" . $i . "</a>\n";
			
			else 
				$out .= "<a href=\"" . $reload . "&amp;page=" . $i . "\">" . $i . "</a>\n";
			
		endfor;
		
		// next
		if( $page < $tpages ) 
			$out .= "<a href=\"" . $reload . "&amp;page=" . ( $page + 1 ) . "\">" . $nextlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $nextlabel . "</span>\n";
		
		
		// last
		if( $page < ( $tpages - $adjacents ) ) 
			$out .= "<a href=\"" . $reload . "&amp;page=" . $tpages . "\">" . $lastlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $lastlabel . "</span>\n";
		
		
		$out .= "</div>";
		
		return $out;
	}

	function paginate_three( $reload, $page, $tpages, $adjacents ) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		
		$out = "<div class=\"pagin\">\n";
		
		// previous
		if( $page == 1 ) 
			$out .= "<span>".$prevlabel."</span>\n";
		
		elseif( $page == 2 ) 
			$out .= "<a href=\"".$reload."\">".$prevlabel."</a>\n";
		
		else 
			$out .= "<a href=\"".$reload."&amp;page=".( $page-1 )."\">".$prevlabel."</a>\n";
		
		
		// first
		if( $page > ( $adjacents + 1 ) ) 
			$out .= "<a href=\"".$reload."\">1</a>\n";
		
		
		// interval
		if( $page > ( $adjacents + 2 ) ) 
			$out .= "...\n";
		
		
		// pages
		$pmin = ( $page > $adjacents ) ? ( $page - $adjacents ) : 1;
		$pmax = ( $page < ( $tpages - $adjacents ) ) ? ( $page + $adjacents ) : $tpages;
		
		for( $i = $pmin; $i <= $pmax; $i++ ) :
			
			if( $i == $page ) 
				$out .= "<span class=\"current\">".$i."</span>\n";
			
			elseif( $i == 1 ) 
				$out .= "<a href=\"".$reload."\">".$i."</a>\n";
			
			else 
				$out .= "<a href=\"".$reload."&amp;page=".$i."\">".$i."</a>\n";		
		endfor;
		
		// interval
		if( $page < ( $tpages - $adjacents - 1 ) ) 
			$out .= "...\n";
		
		
		// last
		if( $page < ( $tpages - $adjacents ) ) 
			$out .= "<a href=\"".$reload."&amp;page=".$tpages."\">".$tpages."</a>\n";
		
		
		// next
		if( $page < $tpages ) 
			$out .= "<a href=\"" . $reload . "&amp;page=" . ($page+1) . "\">" . $nextlabel . "</a>\n";
		
		else 
			$out .= "<span>" . $nextlabel . "</span>\n";
		 
		
		$out .= "</div>";
		
		return $out;
	}
	
	function paginate( $url, $count, $max, $type ) {
	
		$page = intval( $_GET['page'] );
		
		$adjacents  = intval( $_GET['adjacents'] );

		if( $page <= 0 )  
			$page = 1;
			
		if( $adjacents <= 0 ) 
			$adjacents = 4;
	
		$reload = $url . "&tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
		
		$max_results = $max;			
		$from = ( ( $page * $max_results ) - $max_results );		
		
		$total_results = $count;
																		
		$total_pages = ceil( $total_results / $max_results );
		
				$str .= '<p> 
							Page: ' . $page . ' of ' . $total_pages . '&nbsp; | &nbsp;	
		 					Records per page: ' . $max_results . '&nbsp; | &nbsp;				
		 					Records: ' . ( $max_results * ( $page - 1 ) + 1 ) . '-' . $max_results * $page . '&nbsp; | &nbsp;
		 					Total Records: ' . $total_results . '
				  		</p><p>
						';			
		
				$tpages = ( $_GET['tpages'] ) ? intval( $_GET['tpages'] ) : $total_pages; 		
						
				// Build Page Number Hyperlinks
				//$str .= '<tr><td align="center" colspan="4">';		
				$str .= Pagination::paginate_two( $reload, $page, $tpages, $adjacents );
				$str .= '</p>';				
		
		if( $type == 0 )		
			return "$from, $max_results";
		
		else
			return $str;
			
				
	
	}



}
?>