create table user(
    aadhar_no varchar(20) primary key,
    passwd varchar(20),
    legal_name varchar(20)
)

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