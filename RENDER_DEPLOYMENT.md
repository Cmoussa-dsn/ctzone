# Deploying to Render

This guide will help you deploy your Laravel application to Render using the provided Dockerfile.

## Prerequisites

1. A [Render](https://render.com/) account
2. Your project pushed to a Git repository (GitHub, GitLab, etc.)

## Deployment Steps

### 1. Set Up a Web Service on Render

1. Log in to your Render dashboard
2. Click on "New" and select "Web Service"
3. Connect your Git repository
4. Use the following settings:
   - **Name**: Choose a name for your service (e.g., `ct-zone`)
   - **Environment**: Docker
   - **Branch**: Your main branch (e.g., `main` or `master`)
   - **Root Directory**: Leave empty if your Dockerfile is at the root
   - **Docker Command**: Leave empty to use the CMD from Dockerfile

### 2. Configure Environment Variables

Click on "Environment" and add the necessary environment variables from your `.env` file:

```
APP_KEY=base64:Enk1sLD5DatWE04mNHggLLlU346NMMzwJuBCfQWMNhU=
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-render-url.onrender.com

DB_CONNECTION=mysql
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

Replace the values with your actual configuration.

### 3. Set Up Database

You have two options for your database:

#### Option 1: Use Render's PostgreSQL Database

1. Create a new PostgreSQL database in your Render dashboard
2. Update your environment variables to use PostgreSQL instead of MySQL
3. Make sure your code is compatible with PostgreSQL

#### Option 2: Use External MySQL Database

1. Set up a MySQL database with a provider like:
   - [PlanetScale](https://planetscale.com/)
   - [Amazon RDS](https://aws.amazon.com/rds/)
   - [Digital Ocean](https://www.digitalocean.com/products/managed-databases/)
2. Configure your environment variables to connect to this external database

### 4. Deploy Your Application

1. Click "Create Web Service"
2. Wait for the build and deployment process to complete

### 5. Post-Deployment Steps

After successful deployment, you'll need to run migrations and possibly seeds. You can do this using Render's Shell access:

1. Go to your Web Service dashboard
2. Click on "Shell"
3. Run the following commands:
   ```
   php artisan migrate --force
   php artisan db:seed --force  # If you have seeders
   php artisan storage:link     # If you need to create the storage symlink
   ```

### 6. Verify Deployment

1. Visit your application URL (provided by Render)
2. Test that all features are working correctly
3. Check logs if you encounter any issues

## Troubleshooting

If you encounter issues:

1. Check the "Logs" section in your Render dashboard
2. Ensure all environment variables are set correctly
3. Verify database connection parameters
4. Check that your Dockerfile has the correct configurations

## Additional Resources

- [Render Docker Deployments](https://render.com/docs/docker)
- [Laravel Deployment Best Practices](https://laravel.com/docs/10.x/deployment)
- [Environment Configuration in Laravel](https://laravel.com/docs/10.x/configuration) 