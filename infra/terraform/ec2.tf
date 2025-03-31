resource "aws_instance" "app_server" {
  ami                    = var.ami_id
  instance_type          = var.ec2_instance_type
  subnet_id              = var.subnet_ids[0]
  vpc_security_group_ids = ["sg-07cff90fe68c0d5d4"]
  key_name               = "chikoclock_key"
  iam_instance_profile   = "EC2-AccessRole"

  tags = {
    Name = "ChikoclockEC2"
  }

  user_data = file("${path.module}/userdata.sh")
}
