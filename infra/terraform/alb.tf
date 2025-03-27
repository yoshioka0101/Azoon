resource "aws_lb" "chikoclock_alb" {
  name               = var.alb_name
  internal           = false
  load_balancer_type = "application"
  security_groups    = [aws_security_group.chikoclock_sg.id]
  subnets            = var.subnet_ids

  tags = {
    Name = var.alb_name
  }
}
