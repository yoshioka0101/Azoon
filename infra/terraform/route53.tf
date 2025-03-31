resource "aws_route53_record" "chikoclock" {
  zone_id = "Z09797273KM42YROPP8IV"
  name    = var.domain_name
  type    = "A"

  alias {
    name                   = aws_lb.chikoclock_alb.dns_name
    zone_id                = aws_lb.chikoclock_alb.zone_id
    evaluate_target_health = false
  }
}
