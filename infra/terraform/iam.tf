resource "aws_iam_policy" "s3_put_bucket_policy" {
  name        = "S3PutBucketPolicy"
  description = "Allows updating S3 bucket policies"

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Effect   = "Allow"
        Action   = "s3:PutBucketPolicy"
        Resource = "arn:aws:s3:::chikoclock-video"
      }
    ]
  })
}
