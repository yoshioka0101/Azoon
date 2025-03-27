resource "aws_instance" "app_server" {
  ami             = var.ami_id
  instance_type   = var.ec2_instance_type
  subnet_id       = var.subnet_ids[0]
  security_groups = [aws_security_group.chikoclock_sg.id]
  key_name        = "chikoclock_key"

  tags = {
    Name = "ChikoclockEC2"
  }

  user_data = file("${path.module}/userdata.sh")
}
