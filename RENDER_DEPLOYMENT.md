# Deploying to Render

This guide will help you deploy your Laravel application to Render using the provided Dockerfile.

## Prerequisites

1. A [Render](https://render.com/) account
2. Your project pushed to a Git repository (GitHub, GitLab, etc.)

## Files for Deployment

This repository includes several files to help with deployment:

1. **Dockerfile** - A minimal Docker configuration that sets up Apache and PHP
2. **render.yaml** - Configuration for Render's service
3. **post-deploy.sh** - Script to run after deployment for Laravel setup

## Deployment Steps

### 1. Push Code to Repository

Make sure all files including the Dockerfile, render.yaml, and post-deploy.sh are committed to your repository:

```bash
git add Dockerfile render.yaml post-deploy.sh
git commit -m "Add Render deployment files"
git push
```

### 2. Create a Blueprint on Render

1. Log in to your [Render Dashboard](https://dashboard.render.com/)
2. Click on "New" and select "Blueprint"
3. Connect your Git repository
4. Render will detect the render.yaml file and set up your service

### 3. Configure Environment Variables

Additional environment variables can be added through the Render dashboard:

```
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Run Post-Deployment Steps

After your service is deployed, connect to the shell and run:

```bash
chmod +x post-deploy.sh
./post-deploy.sh
```

This will:
- Install Composer
- Install dependencies
- Set up the Laravel environment
- Run migrations
- Fix permissions

### 5. Database Setup

You have two options for your database:

#### Option 1: Use External MySQL Database

1. Set up a MySQL database with a provider like:
   - [PlanetScale](https://planetscale.com/)
   - [Amazon RDS](https://aws.amazon.com/rds/)
   - [Digital Ocean](https://www.digitalocean.com/products/managed-databases/)
2. Configure your environment variables to connect to this external database

#### Option 2: Use Render PostgreSQL

1. Create a new PostgreSQL database in your Render dashboard
2. Update your environment variables to use PostgreSQL
3. Make any necessary adjustments for PostgreSQL compatibility

## Troubleshooting

If you encounter issues:

1. Check the logs in your Render dashboard
2. Connect to the shell and run the post-deploy.sh script manually
3. Check that your environment variables are set correctly
4. Verify that the database connection is working

## Additional Resources

- [Render Docker Deployments](https://render.com/docs/docker)
- [Laravel Deployment Best Practices](https://laravel.com/docs/10.x/deployment)
- [Environment Configuration in Laravel](https://laravel.com/docs/10.x/configuration) 