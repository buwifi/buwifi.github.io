# _plugins/category_pagination.rb
module Jekyll
  class CategoryPageGenerator < Generator
    safe true

    def generate(site)
      per_page = site.config.dig('pagination', 'per_page') || 4

      # Blog index pagination (/blog/)
      generate_paginated_pages(site, site.posts.docs, per_page, "blog", "services.html", {
        "title" => "Blog",
        "layout" => "services"
      })

      # Category pagination (/categories/:name/)
      site.categories.each do |category, posts|
        generate_paginated_pages(site, posts, per_page, "categories/#{category}", "services.html", {
          "title" => category.capitalize,
          "category" => category,
          "layout" => "services"
        })
      end

      # Tag pagination (/tags/:name/)
      site.tags.each do |tag, posts|
        generate_paginated_pages(site, posts, per_page, "tags/#{tag}", "services.html", {
          "title" => tag.capitalize,
          "tag" => tag,
          "layout" => "services"
        })
      end
    end

    private

    # Generalized pagination for blog, categories, and tags
    def generate_paginated_pages(site, posts, per_page, base_path, layout, data = {})
      total_pages = (posts.size.to_f / per_page).ceil

      (1..total_pages).each do |page_num|
        dir = page_num == 1 ? base_path : "#{base_path}/page#{page_num}"
        site.pages << PaginatedPage.new(site, site.source, dir, layout, data.merge(
          "paginator" => build_paginator(posts, page_num, per_page, total_pages, "/#{base_path}")
        ))
      end
    end

    # Build paginator object
    def build_paginator(posts, page_num, per_page, total_pages, base_path)
      {
        "page" => page_num,
        "per_page" => per_page,
        "posts" => posts.slice((page_num - 1) * per_page, per_page) || [],
        "total_posts" => posts.size,
        "total_pages" => total_pages,
        "previous_page" => page_num > 1 ? page_num - 1 : nil,
        "next_page" => page_num < total_pages ? page_num + 1 : nil,
        "previous_page_path" => page_num > 2 ? "#{base_path}/page#{page_num - 1}/" : "#{base_path}/",
        "next_page_path" => page_num < total_pages ? "#{base_path}/page#{page_num + 1}/" : nil
      }
    end
  end

  class PaginatedPage < Page
    attr_reader :paginator

    def initialize(site, base, dir, layout, data = {})
      @site = site
      @base = base
      @dir  = dir
      @name = "index.html"

      self.process(@name)
      self.read_yaml(File.join(base, "_layouts"), layout)
      self.data.merge!(data)

      # Expose paginator to Liquid
      @paginator = self.data["paginator"]
    end

    # <- Add this method
    def to_liquid
      super.merge({ "paginator" => @paginator })
    end
  end




end
