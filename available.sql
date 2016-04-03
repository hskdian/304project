//Find available rooms (bedroom, ballroom, conference room) from '16-APR-6' to '16-APR-7'

select r.roomno
from room r
where not exists
	(select o.room_no
	from reservation o
	where o.room_no=r.roomno 
	minus
	(select i.room_no
	from reservation i
	where i.to_date < '16-APR-6' or i.from_date > '16-APR-7'))

