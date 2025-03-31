resource "aws_db_instance" "chikoclock_rds" {
  identifier            = "chikoclock-db"
  engine               = "mysql"
  engine_version       = "8.0"
  instance_class       = "db.t3.micro"
  allocated_storage    = 20
  max_allocated_storage = 100
  storage_type         = "gp2"
  multi_az             = false
  publicly_accessible  = false
  db_name              = "chikoclock"
  username            = var.db_username
  password            = var.db_password
  parameter_group_name = "default.mysql8.0"
  skip_final_snapshot = true
  backup_retention_period = 7
  vpc_security_group_ids = [aws_security_group.chikoclock_rds_sg.id]
  db_subnet_group_name    = aws_db_subnet_group.chikoclock_db_subnet.name
  tags = {
    Name = "ChikoclockRDS"
  }
}

resource "aws_db_subnet_group" "chikoclock_db_subnet" {
  name       = "chikoclock-db-subnet"
  subnet_ids = var.subnet_ids
  description = "Subnet group for Chikoclock RDS"
}

resource "aws_security_group" "chikoclock_rds_sg" {
  name_prefix = "chikoclock-rds-sg"
  description = "Allow MySQL access from EC2"
  vpc_id      = var.vpc_id

  ingress {
    from_port   = 3306
    to_port     = 3306
    protocol    = "tcp"
    security_groups = [aws_security_group.chikoclock_sg.id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}
