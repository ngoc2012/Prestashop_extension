# Prestashop_extension
http://localhost/prestashop/admin319fxdg6h/index.php?controller=AdminDashboard&token=378f420f7a1bb695b9e7c85b10968c5b

http://localhost/prestashop/index.php


# Certideal flowchart

## Shops


### ps_shop_group

|id_shop_group|name|share_customer         |share_order|share_stock|active|deleted|
|-------------|----|-----------------------|-----------|-----------|------|-------|
|1            |Certideal|1                      |0          |1          |1     |0      |
|2            |Drop Shipping|1                      |1          |1          |1     |0      |
|3            |Pro |0                      |0          |1          |1     |0      |
|4            |Ext |0                      |0          |1          |1     |0      |


### ps_shop

|id_shop|id_shop_group|name                   |id_category|id_theme|active|deleted|
|-------|-------------|-----------------------|-----------|--------|------|-------|
|1      |1            |certideal FR           |2          |3       |1     |0      |
|2      |1            |Certideal ES           |2          |3       |1     |0      |
|3      |1            |Certideal BE           |2          |3       |1     |0      |
|4      |1            |Certideal IT           |2          |3       |1     |0      |
|5      |2            |The Bradery            |2          |3       |1     |0      |
|6      |3            |Certideal Pro COM      |2          |10      |1     |0      |
|7      |1            |Certideal IR           |2          |3       |1     |0      |
|8      |1            |Certideal NL           |2          |3       |1     |0      |
|9      |1            |Certideal SE           |2          |3       |1     |0      |
|10     |1            |Certideal PT           |2          |3       |1     |0      |
|11     |4            |Iliad                  |2          |7       |1     |0      |
|12     |2            |Veepee                 |2          |3       |1     |0      |
|13     |4            |Yoigo                  |2          |8       |1     |0      |
|14     |4            |GoMo                   |2          |9       |1     |0      |
|15     |3            |Certideal PRO WholeSale|2          |3       |1     |0      |
|16     |1            |Certideal EU           |2          |3       |1     |0      |
|17     |2            |Dipli                  |2          |3       |1     |0      |
|18     |2            |MediaMarkt             |2          |3       |1     |0      |

### ps_shop_url

|id_shop_url|id_shop|domain                 |domain_ssl|physical_uri|virtual_uri|main|active|
|-----------|-------|-----------------------|----------|------------|-----------|----|------|
|1          |1      |devminh.fr             |devminh.fr|/           |           |1   |1     |
|2          |2      |devminh.es             |devminh.es|/           |           |1   |1     |
|3          |3      |devminh.be             |devminh.be|/           |           |1   |1     |
|5          |4      |devminh.it             |devminh.it|/           |           |1   |1     |
|6          |7      |devminh.ir             |devminh.ir|/           |           |1   |1     |
|7          |8      |devminh.nl             |devminh.nl|/           |           |1   |1     |
|8          |9      |devminh.se             |devminh.se|/           |           |1   |1     |
|9          |10     |devminh.pt             |devminh.pt|/           |           |1   |1     |
|10         |11     |abonnes.devminh.fr     |abonnes.devminh.fr|/           |           |1   |1     |
|11         |13     |yoigo.devminh.fr       |yoigo.devminh.fr|/           |           |1   |1     |
|12         |6      |pro.devminh.fr         |pro.devminh.fr|/           |           |1   |1     |
|13         |14     |gomo.devminh.fr        |gomo.devminh.fr|/           |           |1   |1     |
|14         |16     |eu.devminh.com         |eu.devminh.com|/           |           |1   |1     |

## Theme

### ps_theme

|id_theme|name|directory              |responsive|default_left_column|default_right_column|product_per_page|
|--------|----|-----------------------|----------|-------------------|--------------------|----------------|
|1       |default|default                |0         |1                  |1                   |12              |
|3       |certideal|certideal              |0         |1                  |1                   |12              |
|4       |default-bootstrap|default-bootstrap      |1         |1                  |0                   |12              |
|7       |free|free                   |0         |1                  |1                   |12              |
|8       |yoigo|yoigo                  |0         |1                  |1                   |12              |
|9       |gomo|gomo                   |1         |0                  |1                   |12              |
|10      |certideal (pro)|certideal-pro          |1         |1                  |1                   |12              |


## Hook

ps_hook_module

|id_module|id_shop|id_hook|position|
|---------|-------|-------|--------|
|413      |1      |155    |0       |
|413      |1      |158    |0       |
|414      |1      |155    |0       |
|414      |1      |158    |0       |
|415      |1      |158    |0       |
|416      |1      |155    |0       |
|416      |1      |158    |0       |
|565      |1      |8      |0       |
|4        |1      |153    |1       |
|5        |1      |60     |1       |


## Main page

### IndexController
[IndexController](../../override/controllers/front/IndexController.php)

### index.tpl

[index.tpl](../../themes/certideal/index.tpl)

