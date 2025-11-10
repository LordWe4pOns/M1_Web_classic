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
    for _ in range(n):
        nom = fake.word().capitalize()
        description = fake.text(max_nb_chars=200)
        prix = round(random.uniform(5, 200), 2)
        categorie = random.choice(["Electronique", "Bureau", "Maison", "Sport", "Vetements"])
        image = f"{nom.lower()}.jpg"
        cursor.execute("""
            INSERT INTO produits (nom, description, prix, categorie, image)
            VALUES (%s, %s, %s, %s, %s)
        """, (nom, description, prix, categorie, image))

# Exécution
#generate_users(10)
generate_products(50)

conn.commit()
cursor.close()
conn.close()

print("Données Faker insérées avec succès !")
