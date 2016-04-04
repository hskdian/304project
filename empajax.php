<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$conn2 = oci_connect("ora_n9b9", "a40798126", "ug");
$q = $_GET['q'];
$query6 ="select phone, name 
			from customer c 
			where not exists 
				((select i.type from room i) 
				minus 
				(select r.type 
				from room r, reservation o 
				where o.phone = c.phone and r.roomno=o.room_no))";

function execute($query){
	global $conn2;
	$stid = oci_parse($conn2, $query);
	if (!$stid) {
		$e = oci_error($conn2);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$r = oci_execute($stid);
	if (!$r) {
		$e = oci_error($stid);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
		
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		print "<tr>\n";
		foreach ($row as $item) {
			print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		print "</tr>\n";
	}

	oci_free_statement($stid);	
}


if ($q == 'max' || $q == 'min') {
	print "<table id = 'maxmin' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Floor</th><th>Avail. Capacity</th>\n";
	print "</tr>\n";
	print "<tbody>";
	execute("select r.floorno, sum(r.capacity) as totalcapacity
from room r
where r.type = 'bedroom' and (not exists
	(select o.room_no
	from reservation o
	where o.room_no=r.roomno 
	minus
	(select i.room_no
	from reservation i
	where i.to_date < sysdate or i.from_date > sysdate)))
group by r.floorno
having sum(r.capacity) = 
(
	select {$q}(sum(a.capacity))
	from room a
	where a.type = 'bedroom' and (not exists
	(select b.room_no
	from reservation b
	where b.room_no=a.roomno 
	minus
	(select c.room_no
	from reservation c
	where c.to_date < sysdate or c.from_date > sysdate)))
	group by a.floorno
)");
	}
elseif ($q == 'importantcust'){
	global $conn2;
	$stid = oci_parse($conn2, $query6);
	if (!$stid) {
		$e = oci_error($conn2);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	$r = oci_execute($stid);
	if (!$r) {
		$e = oci_error($stid);
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}
	print "<table id = 'employ' class = 'display' cellspacing ='0' >\n";
	print "<thead>\n";
	print "<tr>\n";
	print "<th>Phone Number</th><th>Name</th>\n";
	print "</tr>\n";
	print "<tbody>";
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		print "<tr>\n";
		foreach ($row as $item) {
			print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		print "</tr>\n";
	}
	print "</tbody>";
	print "</table>\n";

	oci_free_statement($stid);	
}

OCILogoff($conn2);

?>
