//Find available rooms (bedroom, ballroom, conference room) from '16-APR-15' to '16-APR-27'

select distinct r.roomno
from room r
where not exists
	(select o.room_no, count(*) 
	from reservation o
	where o.room_no= r.roomno
	group by room_no
	minus
	(select i.room_no, count(*)
	from reservation i
	where i.to_date < '16-APR-15' or i.from_date > '16-APR-27'
	group by room_no))

//find the floorno which has the minimum avialble capacity (only count bedrooms)
select r.floorno, sum(r.capacity) as totalcapacity
from room r
where r.type = 'bedroom' and (not exists
	(select o.room_no, count(*)
	from reservation o
	where o.room_no=r.roomno 
	group by room_no
	minus
	(select i.room_no, count(*)
	from reservation i
	where i.to_date < sysdate or i.from_date > sysdate
	group by room_no)))
group by r.floorno
having sum(r.capacity) = 
(
	select min(sum(a.capacity))
	from room a
	where a.type = 'bedroom' and (not exists
	(select b.room_no, count(*)
	from reservation b
	where b.room_no=a.roomno 
	group by room_no
	minus
	(select c.room_no, count(*)
	from reservation c
	where c.to_date < sysdate or c.from_date > sysdate
	group by room_no)))
	group by a.floorno
)
