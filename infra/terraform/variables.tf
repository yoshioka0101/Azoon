variable "domain_name" {
  default = "chikoclock.org"
}

variable "ec2_instance_type" {
  default = "t3.micro"
}

variable "alb_name" {
  default = "chikoclock-alb"
}

variable "ami_id" {
  default = "ami-094dc5cf74289dfbc"
}

variable "subnet_ids" {
  type    = list(string)
  default = ["subnet-02f8d254a38e4aaf6", "subnet-0a09be0591765b5ae", "subnet-0490bf14de4688b62"]
}

variable "vpc_id" {
  default = "vpc-0636f6433bf156661"
}

variable "my_ip" {
  default = "39.110.229.9/32"
}
