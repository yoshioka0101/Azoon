resource "aws_route53_record" "chikoclock" {
  zone_id = "Z09797273KM42YROPP8IV"
  name    = var.domain_name
  type    = "A"

  alias {
    name                   = "chikoclock-alb-1617192878.ap-northeast-1.elb.amazonaws.com"
    zone_id                = "Z14GRHDCWA56QT"
    evaluate_target_health = false
  }
}
