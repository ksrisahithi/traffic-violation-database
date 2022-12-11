create table user(
    aadhar_no varchar(20) primary key,
    passwd varchar(20),
    legal_name varchar(20)
);

desc user;

create table vehicle_details(
    reg_no varchar(10) primary key,
    reg_date date,
    chassis_no int(20),
    engine_no int(20),
    aadhar_no varchar(20),
    vehicle_class varchar(20),
    fuel varchar(10),
    model varchar(20),
    regn_upto date,
    mv_tax_upto date,
    insurance_upto date,
    pucc_upto date, 
    emission_norms varchar(20),
    rc_status varchar(20),
    foreign key (aadhar_no) references user(aadhar_no)
);

desc vehicle_details;

create table traffic_police(
    id int(10) primary key, 
    name  varchar(20),
    designation varchar(20),
    zone_ varchar(20)
);

desc traffic_police;

create table violation(
    violation_id int(10),
    violation_name varchar(40),
    fine decimal(6, 2)
);

desc violation;
alter table violation add primary key(violation_id);

create table ppl_who_violated(
    traffic_tkt_no int(10) primary key,
    reg_no varchar(10),
    violation_id int(10),
    traffic_police_id int(10),
    due date,
    date_of_violation date,
    foreign key(reg_no) references vehicle_details(reg_no), 
    foreign key(violation_id) references violation(violation_id),
    foreign key(traffic_police_id) references traffic_police(id)
);

desc ppl_who_violated;

--modifications for value insertions

-- alter table ppl_who_violated 
-- add aadhar_no varchar(20); 

-- alter table ppl_who_violated
-- add foreign key(aadhar_no) references user(aadhar_no);

alter table violation
modify violation_name varchar(100);

alter table violation 
modify fine decimal(10, 2);

alter table ppl_who_violated
add pay_status boolean;

--queries 

select reg_no, legal_name, A.aadhar_no FROM user A , vehicle_details B WHERE A.aadhar_no = B.aadhar_no;
select C.reg_no, D.legal_name, D.aadhar_no, B.violation_id, B.fine, A.pay_status from ppl_who_violated A, violation B, vehicle_details C, user D where A.reg_no = C.reg_no and A.violation_id = B.violation_id and C.aadhar_no = D.aadhar_no;


alter table traffic_police add column password varchar(30);
--update the tables
update traffic_police set password = "password123" where id = 1;
update traffic_police set password = "password12345" where id = 2;