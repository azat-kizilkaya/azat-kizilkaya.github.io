const products = [
    {
        id: 9,
        name: "Laon Smart Erkek Polo Tişört Siyah",
        price: 279.90,
        category: "T-Shirt",
        image: "gorseller/6940019b6aa2c-1t.jpg"
    },
    {
        id: 10,
        name: "Tuna Modern Grafik T- Shirt Beyaz",
        price: 799.99,
        category: "T-Shirt",
        image: "gorseller/6941e3eed42ad-tuna-modern-grafik-t-shirt-beyaz-9128-erkek-basic-tisort-lufian-410567-91-B.jpg"
    },
    {
        id: 11,
        name: "Sara Erkek Uzun Kol T- Shırt Açık Kahve",
        price: 999.99,
        category: "T-Shirt",
        image: "gorseller/6941e27398711-sara-erkek-uzun-kol-t-shirt-acik-kahve-erkek-bisiklet-yaka-tisort-lufian-404846-96-B.jpg"
    },
    {
        id: 24,
        name: "Vernon Smart Erkek Polo Tişört Çimen Yeşili",
        price: 899.99,
        category: "T-Shirt",
        image: "gorseller/6941c746eb013-vernon-smart-erkek-polo-tisort-cimen-yesili-erkek-polo-yaka-tisort-lufian-412579-94-B.jpg"
    },
    {
        id: 36,
        name: "Beli Lastikli Ekoseli Gri Pijama",
        price: 399.00,
        category: "Eşofman Altı",
        image: "gorseller/693f1d0e82314-beli-lastikli-ekoseli-gri-pijama-2d239-.jpg"
    },
    {
        id: 37,
        name: "Biyeli Eşofman Altı",
        price: 899.00,
        category: "Eşofman Altı",
        image: "gorseller/694921a90e0af-693ebb0fc574a-1.b.jpg"
    },
    {
        id: 38,
        name: "Basic Ayarlanabilir Paça Bordo Eşofman Altı",
        price: 455.00,
        category: "Eşofman Altı",
        image: "gorseller/693f1a3fce8e4-1.f.jpg"
    },
    {
        id: 39,
        name: "Ayarlanabilir Paça Basic Yeşil Baggy Eşofman Altı",
        price: 500.00,
        category: "Eşofman Altı",
        image: "gorseller/693eca33a2e7f-1.c.jpg"
    },
    {
        id: 40,
        name: "Siyah Baggy Eşofman Altı",
        price: 599.99,
        category: "Eşofman Altı",
        image: "gorseller/693ec5e0197bc-6.a.jpg"
    }
];

// Helper to format currency
const formatCurrency = (amount) => {
    return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(amount);
};
