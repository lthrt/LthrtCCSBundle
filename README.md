# CCSBundle
Contact Bundle

This repo may be deleted at any time.
# LthrtCCSBundle


Configure Main App:
#parameters.yaml:
    ccs_name: ccs

#routing.yml:
    lthrt_ccs:
        resource: "@LthrtCCSBundle/Controller/"
        type:     annotation

#config.yml: (or relevant other paremeters)
    ccs:
        driver:   pdo_pgsql
        host:     "%database_host%"
        port:     "%database_port%"
        dbname:   "%ccs_name%"
        user:     "%database_user%"
        password: "%database_password%"
