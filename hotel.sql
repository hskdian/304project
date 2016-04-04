drop table ballroom;
drop table conferenceroom;
drop table bedroom;
drop table checkout;
drop table containsbed;
drop table bedroomtype;
drop table reservation;
drop table room;
drop table customer;
drop table zipcodecitystate;


create table zipcodecitystate
    (zipcode char(7) not null,
    city varchar(20) not null,
    province varchar(20) not null,
    primary key (zipcode));

create table customer
    (phone char(12) not null,
    name varchar(20) not null,
    age int not null,
    street varchar(90) not null,
    zipcode char(7) not null,
    primary key (phone),
    foreign key (zipcode) references zipcodecitystate,
    constraint check_age check (age >= 18 and age <= 100));
    
create table room
    (roomno int not null,
    floorno int not null,
    smoking char(1) default 'N',
    pet char(1) default 'N',
    availability char(1) default 'Y',
    capacity int not null,
    type varchar(14) not null,
    primary key (roomno),
    constraint smoking_y_n check (smoking in ('Y', 'N')),
    constraint pet_y_n check (pet in ('Y', 'N')),
    constraint avail_y_n check (availability in ('Y', 'N')),
    constraint total_disjoint_check check (type in ('ballroom', 'conferenceroom', 'bedroom')));

create table reservation
    (conf_no char(10) not null,
    room_no int not null,
    card_name varchar(30) not null,
    card_type varchar(11) not null,
    card_no varchar(19) not null,
    exp_date date not null,
    added_date date default sysdate,
    checkin_timestamp timestamp(2) null,
    phone char(12) not null,
    from_date date not null,
    to_date date not null,
    primary key(conf_no),
    foreign key(phone) references customer,
    foreign key(room_no) references room,
    constraint check_from_date check (from_date > added_date),
    constraint check_to_date check (to_date > from_date));
    
create table checkout
    (conf_no char(10) not null,
    extra_cost number default 0,
    checkout_timestamp timestamp(2) default systimestamp,
    damage_cost number default 0,
    primary key(conf_no),
    foreign key(conf_no) references reservation,
    constraint check_extra_cost check (extra_cost >= 0),
    constraint check_damage_cost check (damage_cost >= 0));

create table bedroomtype
    (bedroom_type_name char(11),
    nightlyprice decimal not null,
    numofbath int not null,
    kitchen char(1) default 'N',
    primary key (bedroom_type_name),
    constraint kitchen_y_n check (kitchen in ('Y', 'N')),
    constraint check_price check (nightlyprice > 0),
    constraint check_bath check (numofbath > 0 and numofbath <=3),   
    constraint check_name check (bedroom_type_name in ('bachelor', 'deluxe', 'premier')));

create table bedroom
    (roomno int not null,
    bedroom_type_name char(11) not null,
    primary key (roomno),
    foreign key (roomno) references room,
    foreign key (bedroom_type_name) references bedroomtype,
    constraint check_roomno check (roomno >= 1 and roomno <= 550));

create table containsbed
    (bedname char(11) not null,
    bedroom_type_name char(11) not null,
    numofbeds int not null,   
    primary key (bedname, bedroom_type_name),
    foreign key (bedroom_type_name) references bedroomtype,
    constraint numofbeds_check check (numofbeds > 0 and numofbeds <=3),
    constraint check_bedname check (bedname in ('double', 'queen', 'king')));

    
create table ballroom
    (roomno int not null,
    hourlyprice float not null,
    primary key (roomno),
    foreign key (roomno) references room,
    check (hourlyprice > 0));

create table conferenceroom
    (roomno int not null,
    hourlyprice float not null,
    primary key (roomno),
    foreign key (roomno) references room,
    check (hourlyprice > 0));

insert into zipcodecitystate
values ('V3J 7G7', 'Burnaby', 'British Columbia');

insert into zipcodecitystate
values ('K2P 2R1', 'Ottawa', 'Ontario');

insert into zipcodecitystate
values ('T5G 3A6', 'Edmonton', 'Alberta');

insert into room
values ('101', '1', 'N', 'N', 'Y', '1', 'bedroom');

insert into customer
values ('778-237-6272', 'Marc Calingo', '21', 'Granville','V3J 7G7');

insert into customer
values ('604-444-6272', 'Wade Wilson', '35', 'Apple','K2P 2R1');

insert into customer
values ('778-123-3331', 'Matt Murdoch', '32', 'Orange','V3J 7G7');

insert into customer
values ('603-221-1111', 'Jessica Jones', '27', 'Banana','K2P 2R1');

insert into customer
values ('417-232-6656', 'Luke Cage', '34', 'Lemon','T5G 3A6');

insert into customer
values ('778-112-8897', 'Danny Rand', '24', 'Oak','T5G 3A6');

insert into customer
values ('778-908-8878', 'Peter Parker', '23', 'Main','V3J 7G7');

insert into customer
values ('604-667-7757', 'Tony Stark', '31', 'Broadway','T5G 3A6');

insert into customer
values ('604-113-4445', 'James Howlett', '54', 'Vine','K2P 2R1');

insert into room
values ('102', '1', 'N', 'Y', 'N', '6', 'bedroom'); 

insert into room
values ('140', '1', 'N', 'Y', 'N', '6', 'bedroom'); 

insert into room
values ('135', '1', 'Y', 'Y', 'Y', '2', 'bedroom');

insert into room
values ('220', '2', 'N', 'Y', 'N', '4', 'bedroom');

insert into room
values ('204', '2', 'N', 'Y', 'N', '4', 'bedroom');

insert into room
values ('302', '3', 'Y', 'Y', 'Y', '5', 'bedroom');

insert into room
values ('452', '4', 'Y', 'N', 'N', '2', 'bedroom');

insert into room
values ('503', '5', 'N', 'N', 'Y', '3', 'bedroom');

insert into room
values ('1000', '1', 'N', 'N', 'Y', '300', 'conferenceroom');

insert into room
values ('2000', '2', 'Y', 'N', 'N', '320', 'conferenceroom');

insert into room
values ('3000', '3', 'Y', 'Y', 'Y', '350', 'conferenceroom');

insert into room
values ('4000', '4', 'N', 'Y', 'N', '400', 'conferenceroom');

insert into room
values ('5000', '5', 'Y', 'Y', 'Y', '450', 'conferenceroom');

insert into room
values ('1001', '1', 'N', 'N', 'Y', '500', 'ballroom');

insert into room
values ('2001', '2', 'N', 'Y', 'Y', '500', 'ballroom');

insert into room
values ('3001', '3', 'N', 'Y', 'N', '500', 'ballroom');

insert into room
values ('4001', '4', 'N', 'Y', 'Y', '500', 'ballroom');

insert into room
values ('5001', '5', 'Y', 'Y', 'Y', '500', 'ballroom');

insert into conferenceroom
values ('1000', '21.55');

insert into conferenceroom
values ('2000', '23.55');

insert into conferenceroom
values ('3000', '25.55');

insert into conferenceroom
values ('4000', '27.55');

insert into conferenceroom
values ('5000', '29.55');

insert into ballroom
values ('1001', '32.55');

insert into ballroom
values ('2001', '35.55');

insert into ballroom
values ('3001', '38.55');

insert into ballroom
values ('4001', '41.55');

insert into ballroom
values ('5001', '44.55');

insert into bedroomtype
values ('deluxe', '200', '2', 'Y');

insert into bedroomtype
values ('premier', '300', '3', 'Y');

insert into bedroomtype
values ('bachelor', '100', '1', 'N');

insert into bedroom
values ('102', 'bachelor');

insert into bedroom
values ('101', 'bachelor');

insert into bedroom
values ('135', 'bachelor');

insert into bedroom
values ('140', 'bachelor');

insert into bedroom
values ('302', 'premier');

insert into bedroom 
values ('220', 'deluxe');

insert into bedroom
values ('204', 'premier');

insert into bedroom 
values ('452', 'deluxe');

insert into bedroom
values ('503', 'premier');

insert into bedroom
values ('555', 'premier');

insert into containsbed
values ('double', 'bachelor', '1');

insert into containsbed
values ('king', 'premier', '3');

insert into containsbed
values ('queen', 'deluxe', '2');

insert into reservation (conf_no, room_no, card_name, card_type, card_no, exp_date, phone,from_date, to_date)
values ('1234567890', '302', 'Marc Calingo', 'VISA', '1234567890123456789','29-MAR-20', '778-237-6272', '16-APR-5', '16-APR-10' );

insert into reservation (conf_no, room_no, card_name, card_type, card_no, exp_date, phone,from_date, to_date)
values ('1234567891', '1001', 'Marc Calingo', 'VISA', '1234567890123456789','29-MAR-20', '778-237-6272', '16-APR-5', '16-APR-10' );

insert into reservation (conf_no, room_no, card_name, card_type, card_no, exp_date, phone,from_date, to_date)
values ('1234567892', '1000', 'Marc Calingo', 'VISA', '1234567890123456789','29-MAR-20', '778-237-6272', '16-APR-7', '16-APR-10' );

insert into reservation (conf_no, room_no, card_name, card_type, card_no, exp_date, phone,from_date, to_date)
values ('1234567893', '503', 'Wade Wilson', 'VISA', '1234567890123456789','29-MAR-20', '604-444-6272', '16-APR-8', '16-APR-10' );

insert into reservation (conf_no, room_no, card_name, card_type, card_no, exp_date, phone,from_date, to_date)
values ('1234567834', '503', 'Bryant', 'VISA', '1234567890123456789','29-MAR-20', '604-444-6272', '16-APR-15', '16-APR-25' );

