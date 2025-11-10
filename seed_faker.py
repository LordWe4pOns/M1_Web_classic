import datetime
from faker import Faker
import mysql.connector
import random

# Connexion à MySQL
conn = mysql.connector.connect(
    host="127.0.0.1",
    user="root",
    password="",
    database="2025_M1"
)
cursor = conn.cursor()

fake = Faker("fr_FR")

# Génération d'utilisateurs
#def generate_users(n=10):
#    for _ in range(n):
#        nom = fake.last_name()
#        prenom = fake.first_name()
#        email = fake.unique.email()
#        password = fake.password(length=10)
#        role = random.choice(["admin", "client"])
#        cursor.execute("""
#            INSERT INTO users (prenom, nom, email, password, role)
#            VALUES (%s, %s, %s, %s, %s)
#        """, (prenom, nom, email, password, role))

# Génération de produits
def generate_products(n=20):
    categories = ["Électronique", "Bureau", "Maison", "Sport", "Cuisine", "Jardin", "Informatique"]
    for _ in range(n):
        type_p = random.choice(categories)
        designation_p = fake.word().capitalize() + " " + fake.word()
        prix_ht = round(random.uniform(5, 500), 2)
        date_in = datetime.now().strftime("%Y-%m-%d")
        timeS_in = datetime.now().strftime("%H:%M:%S")
        stock_p = random.randint(5, 50)

        cursor.execute("""
            INSERT INTO produit (type_p, designation_p, prix_ht, date_in, timeS_in, stock_p)
            VALUES (%s, %s, %s, %s, %s, %s)
        """, (type_p, designation_p, prix_ht, date_in, timeS_in, stock_p))

    conn.commit()
    print(f"✅ {n} produits ajoutés avec succès.")

# Exécution
#generate_users(10)
generate_products(50)

conn.commit()
cursor.close()
conn.close()

print("Données Faker insérées avec succès !")
