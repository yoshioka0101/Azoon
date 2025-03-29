resource "aws_s3_bucket" "chikoclock_video" {
  bucket = "chikoclock-video"

}

resource "aws_s3_bucket_public_access_block" "chikoclock_video" {
  bucket                  = aws_s3_bucket.chikoclock_video.id
  block_public_acls       = true
  block_public_policy     = false
  ignore_public_acls      = true
  restrict_public_buckets = true
}

resource "aws_s3_bucket_policy" "chikoclock_video_policy" {
  bucket = aws_s3_bucket.chikoclock_video.id
  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Effect    = "Allow"
        Principal = "*"
        Action = [
          "s3:GetObject",
          "s3:PutObject"
        ]
        Resource = "${aws_s3_bucket.chikoclock_video.arn}/*"
      }
    ]
  })
}
