//Find the customers who reserve all types of room(bedroom, ballroom, conference room)

select name
from customer c
where not exists
	((select i.type
	  from room i)
	  minus
	  (select r.type
	  from room r, reservation o
	  where o.phone = c.phone and r.roomno=o.room_no))